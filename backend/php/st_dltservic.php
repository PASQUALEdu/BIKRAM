<?php
// Asegúrate de haber incluido la conexión ($connect) previamente o inclúyela aquí
if(isset($_POST['stdltserv']))
{
    $idservc = $_POST['txtidc'];
    
    try {

        // Se utiliza DELETE para eliminar el servicio de forma permanente
        $query = "DELETE FROM servicio WHERE idservc = :idservc LIMIT 1";
        $statement = $connect->prepare($query);

        $data = [
            ':idservc' => $idservc
        ];
        $query_execute = $statement->execute($data);

        if($query_execute)
        {
            echo '<script type="text/javascript">
swal("¡Eliminado!", "Servicio eliminado correctamente", "error").then(function() {
    window.location = "../servicio/mostrar.php";
});
</script>';
            exit(0);
        }
        else
        {
            echo '<script type="text/javascript">
swal("Error!", "Error al eliminar el servicio", "error").then(function() {
    window.location = "../servicio/mostrar.php";
});
</script>';
            exit(0);
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
