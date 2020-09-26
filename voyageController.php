<?php 

namespace Controller;

include('utils/pdo.php');

use Utils\pdoDB;

$voyageController = new voyageController();
$method = '';

if (isset($_GET['action']) && $_GET['action'] != "") {
    $method = $_GET['action'];
    $voyageController->$method();
}

class voyageController 
{
	private $pdo; 

    public function __construct()
    {
        $this->pdo = new pdoDB(); 
    }

    public function storeFromRequest() {
        $uploads_dir = '/uploads';

        if ($_FILES['fileToUpload']['tmp_name'] == "" || $_FILES['fileToUpload']['size'] == 0) {
            echo "Aucun fichier n'à été uploadé ou le fichier est vide.";
            return false;
        }

        $tmp_name = $_FILES['fileToUpload']['tmp_name'];
        $name = $_FILES['fileToUpload']['name'];

        if (move_uploaded_file($tmp_name, "./$uploads_dir/$name")) {
            if($this->store("./$uploads_dir/$name")){
                unlink("./$uploads_dir/$name");
                header('Location: index.php');
            }
        }

        if (file_exists("./$uploads_dir/$name"))
            unlink("./$uploads_dir/$name");

        return false;
    }

    public function store($file)
    {
        $fileName = basename($file);
        $content = file_get_contents($file);
        
        if (!$this->isValidJson($content)) {
            echo 'Le fichier est vide ou ne contient pas des données json valides';
            return false;
        }

        $arrayEtape = json_decode($content, TRUE);

        if (!$this->isJsonContainsRequiredEntete($arrayEtape)) {
            echo 'Une des étapes ne contient pas de type ou de transport_number';
            return false;
        }
        
        if ($this->arrayContainsDuplicate($arrayEtape)) {
            echo 'Le fichier de ne peut contenir deux fois la même ville de départ ou arrivée et ne peut avoir une étape vide !';
            return false;
        }

        try{
            $this->pdo->getPdo()->beginTransaction();
            $stmt = $this->pdo->getPdo()->prepare ("INSERT INTO voyages (libelle_fichier, created_at, updated_at) VALUES (:libelle_fichier, NOW(), NOW())");
            $stmt -> bindParam(':libelle_fichier', $fileName);
            $stmt -> execute();
            $voyage_id = $this->pdo->getPdo()->lastInsertId();
            
            if ($voyage_id > 0) {
                
                if ($arrayEtape) {
                    foreach ($arrayEtape as $etape) {
                        $stmt = $this->pdo->getPdo()->prepare ("INSERT INTO etapes (voyage_id, type, `number`, departure_date, arrival_date, departure, arrival, 
                            seat, gate, baggage_drop, created_at, updated_at) 
                            VALUES (:voyage_id, :type, :number, :departure_date, :arrival_date, :departure, :arrival, :seat, :gate, :baggage_drop, NOW(), NOW())");
                        $stmt -> bindValue(':voyage_id', $voyage_id);
                        $stmt -> bindValue(':type', ( isset($etape['type']) && $etape['type'] )? $etape['type'] : null);
                        $stmt -> bindValue(':number', ( isset($etape['number']) && $etape['number'] ) ? $etape['number'] : null);
                        $stmt -> bindValue(':departure_date', isset($etape['departure_date']) ? $etape['departure_date'] : null);
                        $stmt -> bindValue(':arrival_date', isset($etape['arrival_date']) ? $etape['arrival_date'] : null);
                        $stmt -> bindValue(':departure', isset($etape['departure']) ? $etape['departure'] : '');
                        $stmt -> bindValue(':arrival', isset($etape['arrival']) ? $etape['arrival'] : '');
                        $stmt -> bindValue(':seat', isset($etape['seat']) ? $etape['seat'] : '');
                        $stmt -> bindValue(':gate', isset($etape['gate']) ? $etape['gate'] : '');
                        $stmt -> bindValue(':baggage_drop', isset($etape['baggage_drop']) ? $etape['baggage_drop'] : '');
                        $stmt -> execute();
                    }
                }
            }

            $this->pdo->getPdo()->commit();
        }catch (PDOException $e) {
            $this->pdo->getPdo()->rollBack();
            echo 'Échec lors de insertion : ' . $e->getMessage();
            return false;
        }

        return true;
    }

    public function isValidJson($string){
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function isJsonContainsRequiredEntete($arrayEtape){
        if (!empty($arrayEtape)) {
            foreach ($arrayEtape as $etape) {
                if (!(isset($etape['type']) && isset($etape['number']))) {
                    return false;
                }
            }
        }

        return true;
    }

    public function arrayContainsDuplicate($arrayEtape){
        $arrayCityDeparture = array();
        $arrayCityArrival = array();

        if (!empty($arrayEtape)) {
            foreach ($arrayEtape as $etape) {
                if (isset($etape['departure'])) {
                    array_push ($arrayCityDeparture, $etape['departure']);
                }

                if (isset($etape['arrival'])) {
                    array_push ($arrayCityArrival, $etape['arrival']);
                }
            }

            if ((count($arrayEtape) != count(array_unique($arrayCityDeparture))) || (count($arrayEtape) != count(array_unique($arrayCityArrival))))
                return true;
        }

        return false;
    }

    public function listVoyage(){
        $stmt = $this->pdo->getPdo()->prepare("SELECT * FROM voyages order by id desc;");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function showEtapes(){

        $id = $_GET["id"];

        if ($id > 0)  
        { 
            $stmt = $this->pdo->getPdo()->prepare("SELECT * FROM etapes where voyage_id = $id order by id asc;");
            $stmt->execute();
            return $stmt->fetchAll();
        }

        return '';
    }

    public function deleteVoyage(){
        $id = $_GET["id"];

        if ($id > 0) 
        {
            $sql = "DELETE FROM voyages WHERE id = $id";
            $this->pdo->getPdo()->exec($sql);
        }

        header('Location: index.php');
    }
}

?>

