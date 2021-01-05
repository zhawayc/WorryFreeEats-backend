<?php
    require_once(__DIR__."/ConnectionManager.php");
    
    class AllergyTypeDao{
        private $connectionManager;
        static $allergyTypeDao = null;

        public function __construct(){
            $this->connectionManager = new ConnectionManager();
        }

        public function __destruct(){
            $this->connectionManager->getConnection()->close();
        }

        public static function getInstance(){
            if(self::$allergyTypeDao==null){
                self::$allergyTypeDao = new AllergyTypeDao();
            }
            return self::$allergyTypeDao;
        }

        public function getAllergyTypeByAllergyTypeId($allergyTypeId){
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT * FROM AllergyType WHERE AllergyTypeID='$allergyTypeId';";
            $result = $conn->query($sql);
            return $result->fetch_assoc()["Allergy"];
        }

        public function getAllergies(){
            $conn = $this->connectionManager->getConnection();
            $sql = "SELECT Allergy FROM AllergyType;";
            $result = $conn->query($sql);
            $res = array();
            while($row = $result->fetch_assoc()){
                if($row["Allergy"]=="NotAllergy"){
                    continue;
                }
                array_push($res, $row["Allergy"]);
            }
            return $res;
        }
    }
?>