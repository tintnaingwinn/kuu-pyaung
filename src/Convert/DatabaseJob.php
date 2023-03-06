<?php

namespace Tintnaingwin\KuuPyaung\Convert;

use Doctrine\DBAL\Types\Type;
use Exception;
use Illuminate\Database\Connection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Tintnaingwin\KuuPyaung\Exceptions\InvalidConvertJob;
use Tintnaingwin\KuuPyaung\Models\Dynamic;
use Tintnaingwin\MyanFont\Facades\MyanFont;

class DatabaseJob
{
    /**
     * Supported data types.
     */
    protected array $columnDataTypes = ['char', 'string', 'text'];

    /**
     * These will be excluded from the convert.
     */
    protected $excludeTables;

    protected Connection $db_connection;

    /**
     * a list of included convert tables in the current database.
     *
     * @var string[]
     */
    protected array $tables;

    /**
     * The primary keys for the table.
     *
     * @var string[]
     */
    protected array $primaryKeys = ['id', 'uuid'];

    /**
     * DatabaseJob constructor.
     */
    public function __construct()
    {
        $this->addOtherDataTypes();
        $this->setExcludeTables(config('kuu-pyaung.exclude_tables'));

        $this->db_connection = DB::connection();
        $this->tables = $this->getTableNames();
    }

    /**
     * The list of $tables[] that will be converted from zawgyi to unicode.
     */
    public function convert(): void
    {
        try {
            if (! count($this->tables)) {
                throw InvalidConvertJob::noTableToBeConvert();
            }

            commandText()->info('Starting convert database from zawgyi to unicode...');
            commandText()->getOutput()->newLine();

            foreach ($this->tables as $table) {
                $columns = $this->getTableStringColumns($table);

                if (! count($columns)) {
                    continue;
                }

                $this->convertTable($table, $columns);
            }
        } catch (Exception $exception) {
            commandText()->error("Convert failed because {$exception->getMessage()}");
            commandText()->getOutput()->newLine();
        }
    }

    /**
     * @var \Tintnaingwin\KuuPyaung\Models\Dynamic
     */
    public function convertTable($table, $columns): void
    {
        $model = new Dynamic();
        $model->setTable($table);

        $count = $model->count();

        if (! $count) {
            return;
        }

        commandText()->info("Converting {$table} table...");

        commandText()->getOutput()->progressStart($count);

        $model->select($columns)->chunk(100, function ($data) use ($columns) {
            foreach ($data as $value) {
                foreach ($columns as $column) {
                    $value->{$column} = MyanFont::zg2uni($value->{$column});
                }

                $value->timestamps = false;
                $value->save();

                commandText()->getOutput()->progressAdvance();
            }
        });

        commandText()->getOutput()->progressFinish();
    }

    /**
     * Declare the unsupported data types to other type.
     */
    protected function addOtherDataTypes(): void
    {
        try {
            Type::addType('other', 'Tintnaingwin\KuuPyaung\Doctrine\OtherType');

            DB::getDoctrineConnection()->getDatabasePlatform()?->registerDoctrineTypeMapping('enum', 'other');
            DB::getDoctrineConnection()->getDatabasePlatform()?->registerDoctrineTypeMapping('geometry', 'other');
            DB::getDoctrineConnection()->getDatabasePlatform()?->registerDoctrineTypeMapping('geomcollection', 'other');
            DB::getDoctrineConnection()->getDatabasePlatform()?->registerDoctrineTypeMapping('linestring', 'other');
            DB::getDoctrineConnection()->getDatabasePlatform()?->registerDoctrineTypeMapping('multilinestring', 'other');
            DB::getDoctrineConnection()->getDatabasePlatform()?->registerDoctrineTypeMapping('multipoint', 'other');
            DB::getDoctrineConnection()->getDatabasePlatform()?->registerDoctrineTypeMapping('multipolygon', 'other');
            DB::getDoctrineConnection()->getDatabasePlatform()?->registerDoctrineTypeMapping('polygon', 'other');
            DB::getDoctrineConnection()->getDatabasePlatform()?->registerDoctrineTypeMapping('point', 'other');
        } catch (\Doctrine\DBAL\Exception $e) {
            commandText()->error($e->getMessage());
        }
    }

    /**
     * Get the include tables.
     */
    protected function getTableNames(): array
    {
        $tables = $this->db_connection->getDoctrineSchemaManager()->listTableNames();

        return $this->filterTableNames($tables);
    }

    /**
     * Remove the $excludeTable from the current tables.
     *
     * @param  array  $tables
     */
    protected function filterTableNames($tables): array
    {
        return array_diff($tables, $this->excludeTables);
    }

    /**
     * Get the string columns only.
     */
    protected function getTableStringColumns($table): array
    {
        try {
            $columns = $this->db_connection->getDoctrineSchemaManager()->listTableColumns($table);

            if (! $this->hasPrimaryKey($columns)) {
                throw InvalidConvertJob::noPrimaryKey($table);
            }

            $columns = $this->filterTableColumns($columns, $table);

            return array_map('self::removeExtraQuotes', $columns);
        } catch (Exception $exception) {
            commandText()->error("Convert failed because {$exception->getMessage()}");
            commandText()->getOutput()->newLine();

            return [];
        }
    }

    /**
     * Remove the non-string columns from current columns.
     *
     * @param  \Doctrine\DBAL\Schema\Column[]  $columns
     * @return \Doctrine\DBAL\Schema\Column[]
     */
    protected function filterTableColumns($columns, $table): array
    {
        $columns = array_filter($columns, function ($column) {
            /**
             * @var \Doctrine\DBAL\Schema\Column $column
             */
            if ($this->isPrimaryKey($column->getName())) {
                return true;
            }

            $column_data_type = $column->getType()->getName();

            return in_array($column_data_type, $this->columnDataTypes);
        });

        $columns = array_keys($columns);

        if ($exclude_table_columns = $this->getExcludeTableColumns($table)) {
            $columns = array_diff($columns, $exclude_table_columns);
        }

        return $columns;
    }

    protected function getExcludeTableColumns($table)
    {
        return config('kuu-pyaung.exclude_table_columns.'.$table);
    }

    /**
     * Determine the column is primary or not.
     */
    protected function isPrimaryKey($name): bool
    {
        return in_array($name, $this->primaryKeys);
    }

    /**
     * Determine if the primary key exist or not in the table.
     */
    protected function hasPrimaryKey($columns): bool
    {
        foreach ($this->primaryKeys as $primaryKey) {
            if (Arr::exists($columns, $primaryKey)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Remove the extra quotes.
     */
    protected function removeExtraQuotes(string $value): string
    {
        return str_replace(['`', '"', "'"], '', $value);
    }

    /**
     * Set to exclude tables.
     *
     * @return $this
     */
    public function setExcludeTables(array $excludeTables): static
    {
        $this->excludeTables = $excludeTables;

        return $this;
    }
}
