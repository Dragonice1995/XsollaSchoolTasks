<?php
namespace webApp;
use mysqli;
class Model implements TableModel {
    private $rows = array();
    private $updatedRows = array();
    private $deletedRows = array();

    public function getHeaders()
    {
        return array_keys($this->rows[0]);
    }

    public function load()
    {
        $mysqli = new mysqli('10.10.10.33', 'root', 'root', 'test');
        if ($mysqli->connect_errno) {
            echo "Ошибка: " . $mysqli->connect_error . "\n";
        } else {
            $sql = 'SELECT * FROM Grunfeld';
            $result = $mysqli->query($sql);
            while ($row = $result->fetch_assoc()) {
                array_push($this->rows, $row);
            }
        }
        $mysqli->close();
    }

    public function save()
    {
        $mysqli = new mysqli('10.10.10.33', 'root', 'root', 'test');
        if ($mysqli->connect_errno) {
            echo "Ошибка: " . $mysqli->connect_error . "\n";
        } else {
            $sql = '';
            foreach ($this->updatedRows as $row) {
                if (in_array($row['id'], array_column($this->rows, 'id'))) {
                    $sql = $sql."UPDATE Grunfeld SET firm = ".$row['firm'].", year = ".$row['year'].", inv = "
                        .$row['inv'].", value = ".$row['value'].", capital = ".$row['capital']." WHERE id = ".$row['id'].";\n";
                } else {
                    $sql = $sql."INSERT INTO Grunfeld(id, firm, year, inv, value, capital) VALUES (".$row['id'].","
                        .$row['firm'].",".$row['year'].",".$row['inv'].",".$row['value'].",".$row['capital'].");\n";
                }
            }
            foreach ($this->deletedRows as $row) {
                $sql = $sql."DELETE FROM Grunfeld WHERE id = ".$row['id'].";\n";
            }
            $mysqli->query($sql);
        }
        $mysqli->close();
    }

    public function addRow(array $row)
    {
        $maxId = max(array_column($this->rows, 'id'));
        $newRow = [
            'id' => $maxId + 1,
            'firm' => $row['firm'],
            'year' => $row['year'],
            'inv' => $row['inv'],
            'value' => $row['value'],
            'capital' => $row['capital']
        ];
        array_push($this->updatedRows, $newRow);
    }

    public function updateRow($offset, array $row)
    {
        if (in_array($offset, array_column($this->rows, 'id'))) {
            $newRow = [
                'id' => $offset,
                'firm' => $row['firm'],
                'year' => $row['year'],
                'inv' => $row['inv'],
                'value' => $row['value'],
                'capital' => $row['capital']
            ];
            array_push($this->updatedRows, $newRow);
            return true;
        } else {
            return false;
        }
    }

    public function getRow($offset)
    {
        foreach ($this->rows as $row) {
            if ($row['id'] == $offset) {
                return $row;
            }
        }
    }

    public function deleteRow($offset)
    {
        $flag = false;
        for ($i = 0; $i < count($this->rows) && !$flag; $i++) {
            $flag = $offset == $this->rows[$i]['id'];
            if ($flag) {
                array_push($this->deletedRows, $this->rows[$i]);
            }
        }
        if ($flag) {
            return true;
        } else {
            return false;
        }
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function countRows()
    {
        return count($this->rows);
    }
}