<?php
namespace webApp;
use PHPUnit\Framework\TestCase;
use mysqli;
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/model.php';
require_once __DIR__ . '/../src/TableModel.php';

class modelTest extends TestCase {
    private $model;

    public function setUp()
    {
        $this->model = new model();
    }

    public function testGetHeaders() {
        $this->model->load();
        $headers = ['id', 'firm', 'year', 'inv', 'value', 'capital'];
        $this->assertEquals($headers, $this->model->getHeaders());
    }

    public function dataUpdateRowTest() {
        return [
            [200,
                [
                    'firm' => 10,
                    'year' => 1945,
                    'inv' => 1.36,
                    'value' => 65.85,
                    'capital' => 3.31
                ]
            ],
            [1,
                [
                    'firm' => 11,
                    'year' => 1935,
                    'inv' => 317.6,
                    'value' => 3078.5,
                    'capital' => 2.8
                ]
            ]
        ];
    }

    /**
     * @dataProvider dataUpdateRowTest
     **/
    public function testUpdateRow($id, $row) {
        $this->model->load();
        $this->assertEquals(true, $this->model->updateRow($id, $row));
    }

    public function dataGetRowTest() {
        return [
            200,
            1,
            0
        ];
    }
    /**
     * @dataProvider dataGetRowTest
     **/
    public function testGetRow($id) {
        $mysqli = new mysqli('10.10.10.33', 'root', 'root', 'test');
        $sql = 'SELECT count(*) FROM Grunfeld WHERE id = '.$id;
        $result = $mysqli->query($sql);
        $this->model->load();
        $this->assertEquals($result->fetch_assoc(), $this->model->getRow());
    }

    public function dataDeleteTest() {
        return [
            200,
            1,
            0
        ];
    }
    /**
     * @dataProvider dataDeleteTest
     **/
    public function testDeleteRow($id) {
        $this->model->load();
        $this->assertEquals(true, $this->model->deleteRow($id));
    }

    public function testGetRows() {
        $mysqli = new mysqli('10.10.10.33', 'root', 'root', 'test');
        $sql = 'SELECT * FROM Grunfeld';
        $result = $mysqli->query($sql);
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            array_push($rows, $row);
        }
        $this->model->load();
        $this->assertEquals($rows, $this->model->getRows());
    }

    public function testCountRows() {
        $mysqli = new mysqli('10.10.10.33', 'root', 'root', 'test');
        $sql = 'SELECT count(*) FROM Grunfeld';
        $result = $mysqli->query($sql);
        $this->model->load();
        $this->assertEquals($result->fetch_row()[0], $this->model->countRows());
    }
}