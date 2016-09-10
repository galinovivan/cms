<?php
class Article {
    //id  статей из бд
    public $id = null;

    // дата публикации

    public $publicationDate = null;

    // Полное название статьи

    public $title = null;

    // краткое описание

    public $summary = null;

    // HTML содержание

    public $content = null;

    // Установка значениий мест
    // конструктор класса

    public function __construct($data = array()) {
    if (isset($data['id'])) {
        $this->id = (int) $data['id'];
    }
    if (isset($data['publicationDate'])) {
        $this->publicationDate = (int) $data['publicationDate'];
    }
    if (isset($data['title'])) {
        $this->title = preg_replace( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title']);
    }
    if (isset($data['summary'])) {
        $this->summary = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['summary']);
    }
    if (isset($data['content'])) {
        $this->content = $data['content'];
    }
    }

    // установка значений с форм админки
    // запись значений форм
    public function storeFormValues($params) {
        // сохранение параментров
        $this->__construct($params);

        // разбоор и сохранение даты публикации

        if (isset($params['publicationDate'])) {
           $publicationDate = explode('-', $params['publicationDate']);

            if (count($publicationDate) == 3) {
                list($y, $m, $d) = $publicationDate;
                $this->publicationDate = mktime(0, 0, 0, $m, $d, $y);
            }
        }
    }

    // возвращаем обьект статьи соответвующему текущему id
    // return Article или false если не найдена

    public static function getById($id)
    {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ($row) {
            return new Article($row);
        }
    }
        /*
         * Возвращаем все (или диапазон) обьектов статей в бд
         * int Optinal кол-то строк (по дефолту все)
         * string Optinal Столбец по которому производится сортировка статей (по дефолту "publicationDate DESC")
         * return Array|false Двух элементный массив: results => массив, список объектов статей; totalRows =>
         * общее количество статей
         */

        public static function getList($numRows = 1000000, $order = "publicationDate DESC") {
            $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles
                ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";
            $st = $conn->prepare($sql);
            $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
            $st->execute();
            $list = array();
            while ($row = $st->fetch()) {
                $article = new Article($row);
                $list[] = $article;
            }
            // получаем общее количество статей, соотвествющие критерию
            $sql = "SELECT FOUND_ROWS() AS totalRows";
            $totalRows = $conn->query($sql)->fetch();
            $conn = null;
            return (array("results" => $list, "totalRows" => $totalRows[0]));
        }
        /*
         * Вставляем текущий обьект в бд, устанавливаем его св-ва
         */
        public function insert() {
            // если у обькта есть id
            if (!is_null($this->id)) {
                trigger_error("Article::insert(): Attemp to insert an Article object that already has its ID property
                 set (to $this->id ).", E_USER_ERROR);
            }
            else {
                // вставляем статью
                $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                $sql = "INSERT INTO articles (publicationDate, title, summary, content) VALUES (
            FROM_UNIXTIME(:publicationDate), :title, :summary, :content)";
                $st = $conn->prepare($sql);
                $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
                $st->bindValue(":title", $this->title, PDO::PARAM_STR);
                $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
                $st->bindValue(":content", $this->content, PDO::PARAM_STR);
                $st->execute();
                $this->id = $conn->lastInsertId();
                $conn = null;
            }
        }

        /*
         * обновляем текущий обьект статьи в бд
         */


        public function update() {
            if (is_null($this->id)) {
                trigger_error("Article::insert(): Attemp to insert an Article object that already has its ID property
                 set (to $this->id ).", E_USER_ERROR);
            }
            // обновляем статью
            else {
                $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                $sql = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate), title=:title,
                summary=:summary,content=:content, WHERE id= :id";
                $st = $conn->prepare($sql);
                $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
                $st->bindValue(":title", $this->title, PDO::PARAM_STR);
                $st->bindValue(":summary", $this->summary, PDO::PARAM_STR);
                $st->bindValue(":content", $this->summary, PDO::PARAM_STR);
                $st->bindValue(":content", $this->id, PDO::PARAM_INT);
                $st->execute();
                $conn = null;
            }
        }

          /*
         * удаляем текущиц обьект из БД
         */

          public function delete() {
              if (is_null($this->id)) {
                  trigger_error("Article::insert(): Attemp to insert an Article object that already has its ID property
                 set (to $this->id ).", E_USER_ERROR);
              }
              else {
                  // удаляем статью
                  $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                  $st = $conn->prepare("DELETE FROM articles WHERE id = :id LIMIT 1");
                  $st->bindValue(":id", $this->id, PDO::PARAM_INT);
                  $st->execute();
                  $conn = null;
              }
          }
        }
?>