<?php

namespace BeforeAfter\BASRS;

class Schema {

    /**
     * Holds choosen schema file
     * @var type 
     */
    private $schemaConfig;

    /**
     * Hollds Name of current selected schema
     * @var type 
     */
    private $schemaName;

    /**
     * Holds dir to schema
     * @var type 
     */
    private $schemaDir;

    /**
     * List of schemas
     * @var type 
     */
    private $aviableSchemas;

    /**
     * 
     */
    public function __construct() {

        $this->schemaDir = BASRS_PATH . 'schemas';
        /**
         * Gets aviable schemas
         */
        $this->getSchemasList();
    }

    /**
     * Scans dir with jsons and convert them to reusable php files
     */
    public function getSchemasList() {

        $directory = array_slice(scandir($this->schemaDir), 2);
       
        $temp = [];
        foreach ($directory as $key => $file) {
            /**
             * Skip directories
             */
            if (!is_dir($this->schemaDir . DIRECTORY_SEPARATOR . $file)) {
                /**
                 * Get content from found json
                 */
                $file = file_get_contents($this->schemaDir . DIRECTORY_SEPARATOR . $file);


                /**
                 * Add this content to param
                 */
//                if (!empty(json_decode($file, true))) {
                    $temp[] = json_decode($file);
                    $this->aviableSchemas[] = json_decode($file, true);
//                }
            }
        }
    }

    /**
     * Gets Object of schemas
     * @return type
     */
    public function getSchemas() {


        $schemas = $this->aviableSchemas;

        return $schemas;
    }

    /**
     * Retrives searched schema
     * @param type $name
     */
    public function getSchema($searchedSchema) {


        $schemas = $this->getSchemas();


        if (!empty($schemas)) {
            foreach ($schemas as $schema) {
//                debug($schemas);
                /**
                 * Checks each schema if has assigned name as searched value
                 */
                if (strtolower($schema['name']) === strtolower($searchedSchema)) {
                    return $schema;
                }
//                else {
//                    return [
//                        'error' => __('Could not find searched config file')
//                    ];
//                }
            }
        }
        else {
            return [
                'error' => __('Could not find any schema config file')
            ];
        }
    }

}
