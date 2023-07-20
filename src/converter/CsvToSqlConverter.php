<?php
namespace taskforce\converter;

use DirectoryIterator;
use SplFileInfo;
use SplFileObject;
use taskforce\ex\ConverterException;

class CsvToSqlConverter
{
    /**
     * @var SplFileInfo[]
     */
    protected array $files_to_convert = [];

    /**
     * @throws ConverterException
     */
    public function __construct(string $directory)
    {
        if (!is_dir($directory)) {
            throw new ConverterException("Directory does not exist");
        }

        $this->load_csv_files($directory);
    }

    /**
     * @param string $directory
     * @return void
     */
    protected function load_csv_files(string $directory): void
    {
        foreach (new DirectoryIterator($directory) as $file) {
            if ($file->getExtension() == 'csv') {
                $this->files_to_convert[] = $file->getFileInfo();
            }
        }
    }

    /**
     * @param string $table_name
     * @param array $columns
     * @param array $values
     * @return string
     */
    protected function get_sql_content(string $table_name, array $columns, array $values): string
    {
        $string_columns = implode(', ', $columns);
        $sql = "INSERT INTO $table_name ($string_columns) VALUES ";

        foreach ($values as $row) {
            array_walk($row, function (&$value) {
                $value = addslashes($value);
                $value = "'$value'";
            });

            $sql .= "( " . implode(', ', $row) . "), ";
        }

        return substr($sql, 0, -2);
    }

    /**
     * @param string $table_name
     * @param string $directory
     * @param string $content
     * @return string
     * @throws ConverterException
     */
    protected function save_sql_content(string $table_name, string $directory, string $content): string
    {
        if (!is_dir($directory)) {
            throw new ConverterException('Output directory does not exist');
        }

        $file_name = $directory . DIRECTORY_SEPARATOR . $table_name . '.sql';

        file_put_contents($file_name, $content);

        return  $file_name;
    }


    /**
     * @param SplFileInfo $file
     * @param string $output_directory
     * @return string
     * @throws ConverterException
     */
    protected function convert_file(SplFileInfo $file, string $output_directory):string
    {
        $file_obj = new SplFileObject($file->getRealPath());
        $file_obj->setFlags(SplFileObject::READ_CSV);

        $columns = $file_obj->fgetcsv();
        $values = [];

        while (!$file_obj->eof()) {
            $values[] = $file_obj->fgetcsv();
        }

        $table_name = $file->getBasename('.csv');
        $sql_content = $this->get_sql_content($table_name, $columns, $values);

        return $this-> save_sql_content($table_name, $output_directory, $sql_content);
    }


    /**
     * @param string $output_directory
     * @return array
     */
    public function convert_files(string $output_directory): array
    {
        $result = [];

        foreach ($this->files_to_convert as $file) {
            try {
                $result[] = $this->convert_file($file, $output_directory);
            } catch (ConverterException $e) {
                $e->getMessage();
            }
        }

        return $result;
    }
}
