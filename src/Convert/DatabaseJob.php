<?php

namespace Tintnaingwin\KuuPyaung\Convert;

use Doctrine\DBAL\DBALException;
use Exception;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\Facades\DB;
use Tintnaingwin\KuuPyaung\Exceptions\InvalidConvertJob;
use Tintnaingwin\KuuPyaung\Models\Dynamic;
use Tintnaingwin\MyanFont\Facades\MyanFont;

class DatabaseJob
{
    /**
     * Supported data types.
     */
    protected $columnDataTypes = [ 'char', 'string', 'text' ];

    /**
     * These will be excluded from the convert.
     */
    protected $excludeTables;

    /**
     * @var \Illuminate\Database\Connection
     */
    protected $db_connection;

    /**
     * a list of included convert tables in the current database.
     *
     * @var string[]
     */
    protected $tables;

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
     * The list of $tables[] that will be convert from zawgyi to unicode.
     *
     * @return void
     */
    public function convert()
    {
        try {
            if (!count($this->tables)) {
                throw InvalidConvertJob::noTableToBeConvert();
            }

            commandText()->info('Starting convert database from zawgyi to unicode...');
            commandText()->getOutput()->newLine();

            foreach ($this->tables as $table) {

                $columns = $this->getTableStringColumns($table);

                if (!count($columns)) {
                    continue;
                }

                $this->convertTable($table, $columns);
            }
        }catch (Exception $exception) {
            commandText()->error("Convert failed because {$exception->getMessage()}");
            commandText()->getOutput()->newLine();
        }
    }

    /**
     * @param $table
     * @param $columns
     *
     * @var \Tintnaingwin\KuuPyaung\Models\Dynamic $model
     */
    public function convertTable($table, $columns)
    {
        $select_columns = $this->addIdColumn($columns);

        $model = new Dynamic();
        $model->setTable($table);

        $count = $model->count();

        if (!$count) {
            return;
        }

        commandText()->info("Converting {$table} table...");

        commandText()->getOutput()->progressStart($count);

        $model->select($select_columns)->orderBy('id')->chunk(100, function ($data) use($columns){
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
     * Add id column.
     *
     * @param array $columns
     * @return array
     */
    protected function addIdColumn($columns)
    {
        array_push($columns, 'id');
        return $columns;
    }

    /**
     * Declare the unsupported data types to other type.
     *
     * @return void
     */
    protected function addOtherDataTypes()
    {
        try {
            Type::addType('other', 'Tintnaingwin\KuuPyaung\Doctrine\OtherType');

            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'other');
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('geometry', 'other');
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('geomcollection', 'other');
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('linestring', 'other');
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('multilinestring', 'other');
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('multipoint', 'other');
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('multipolygon', 'other');
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('polygon', 'other');
            DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('point', 'other');

        } catch (DBALException $e) {
            commandText()->error($e->getMessage());
        }
    }

    /**
     * Get the include tables.
     *
     * @return array
     */
    protected function getTableNames()
    {
        $tables = $this->db_connection->getDoctrineSchemaManager()->listTableNames();

        return $this->filterTableNames($tables);
    }

    /**
     * Remove the $excludeTable from the current tables.
     *
     * @param array $tables
     * @return array
     */
    protected function filterTableNames($tables)
    {
        return array_diff($tables, $this->excludeTables);
    }

    /**
     * Get the string columns only.
     *
     * @param $table
     * @return array
     */
    protected function getTableStringColumns($table)
    {
        $columns = $this->db_connection->getDoctrineSchemaManager()->listTableColumns($table);

        $columns = $this->filterTableColumns($columns);

        return array_keys($columns);
    }

    /**
     * Remove the non-string columns from current columns.
     *
     * @param \Doctrine\DBAL\Schema\Column[] $columns
     * @return \Doctrine\DBAL\Schema\Column[]
     */
    protected function filterTableColumns($columns)
    {
        $columns = array_filter($columns, function ($column)
            {
                /**
                 * @var \Doctrine\DBAL\Schema\Column $column
                 */
                $column_data_type = $column->getType()->getName();

                return in_array($column_data_type, $this->columnDataTypes);
            });

        return $columns;
    }

    /**
     * Set the exclude tables.
     *
     * @param array $excludeTables
     * @return $this
     */
    public function setExcludeTables($excludeTables)
    {
        $this->excludeTables = $excludeTables;

        return $this;
    }
}
