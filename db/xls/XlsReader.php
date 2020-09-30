<?php

class XlsReader
{
    static $inputFileName = __DIR__ . '/data.xlsx';

    public static function getDocument()
    {
        return \PhpOffice\PhpSpreadsheet\IOFactory::load(self::$inputFileName);
    }

    public static function getFormattedDataForPage($page) {
        $xlsx = self::getDocument();
        $page = $xlsx->getSheet($page);
        $data = $page->toArray(null, false, true, true);
        $names = array_shift($data);
        $seeds = [];

        foreach ($data as $entry) {
            $temp = [];
            foreach($entry as $key => $value) {
                if(in_array($names[$key], ['DATE_TIME', 'MODIFIED_DTG'])) {
                    $value = date_format(date_create($value), 'Y-m-d h:i:s');
                }

                $temp[$names[$key]] = $value;
            }
            array_push($seeds, $temp);
        }
        return $seeds;
    }
}