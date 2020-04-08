<?php
/**
 * Clase DbTable para administrar los archivos en la Base de Datos
 *
 * @author rafael
 */
class Application_Model_DbTable_ZfArchivo extends Zend_Db_Table_Abstract
{
    protected $_name = 'zf_archivo';
    protected $_schema = 'sch_sjud';
    protected $_sequence = false;
    protected $_uniqueIdPrefix = '';

    /**
     * Inserta un archivo dado la dirección del mismo
     *
     * @param string $filename Dirección y nombre del archivo
     * @param string $descripcion Descripción del archivo.
     * @return integer Retorna el ID insertado
     * @throws Exception
     */
    public function insertByFilename($filename, $descripcion = '')
    {
        if (!file_exists($filename)) {
            throw new InvalidArgumentException("Archivo '$filename' no existe");
        }
        $sql = "INSERT INTO {$this->getAdapter()->quoteIdentifier(array($this->_schema, $this->_name))} "
             . '(id, contenido, tamanio, nombre, descripcion, tipo_mime, suma_comprobacion, directorio) '
             . 'VALUES (:id, :contenido, :tamanio, :nombre, :descripcion, :tipo_mime, :suma_comprobacion, :directorio) '
             . 'RETURNING id';

        $uniqueid = strtoupper(uniqid($this->_uniqueIdPrefix));
        $stmt = $this->getAdapter()->prepare($sql);
        $stmt->bindValue(':id', $uniqueid, PDO::PARAM_STR);
        $stmt->bindValue(':contenido', fopen($filename, 'rb'), PDO::PARAM_LOB);
        $stmt->bindValue(':suma_comprobacion', md5_file($filename), PDO::PARAM_STR);
        $stmt->bindValue(':tamanio', filesize($filename), PDO::PARAM_INT);
        $stmt->bindValue(':nombre', basename($filename), PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindValue(':directorio', dirname($filename), PDO::PARAM_STR);
        $stmt->bindValue(':tipo_mime', finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filename), PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->id;
    }

    /**
     * Actualiza la información de un archivo dado.
     *
     * @param integer $id
     * @param string $filename
     * @param string $descripcion
     * @return integer
     * @throws Exception
     */
    public function updateById($id, $filename, $descripcion = '')
    {
        if (!file_exists($filename)) {
            throw new InvalidArgumentException("Archivo '$filename' no existe");
        }

        $sql = "UPDATE {$this->getAdapter()->quoteIdentifier(array($this->_schema, $this->_name))} "
             . 'SET contenido = :contenido, tamanio = :tamanio, nombre = :nombre, descripcion = :descripcion, '
             . 'tipo_mime = :tipo_mime, suma_comprobacion = :suma_comprobacion, directorio = :directorio '
             . 'WHERE id = :id';

        $stmt = $this->getAdapter()
                     ->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindValue(':contenido', fopen($filename,'rb'), PDO::PARAM_LOB);
        $stmt->bindValue(':suma_comprobacion', md5_file($filename), PDO::PARAM_STR);
        $stmt->bindValue(':tamanio', filesize($filename), PDO::PARAM_INT);
        $stmt->bindValue(':nombre', basename($filename), PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindValue(':directorio', dirname($filename), PDO::PARAM_STR);
        $stmt->bindValue(':tipo_mime', finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filename), PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    /**
     *
     * @param type $id
     * @return type
     */
    public function deleteById($id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException("el parámetro \$id no puede estar vacío");
        }
        $sql = "DELETE FROM {$this->getAdapter()->quoteIdentifier(array($this->_schema, $this->_name))} WHERE id = :id";
        $stmt = $this->getAdapter()
                     ->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
