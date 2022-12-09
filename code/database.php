<?php

class Database {
    private mysqli $db;

    public function connectToDatabase(): void
    {
        $this->db = new mysqli('db', 'root', 'helloworld', 'web');
    }

    public function createBulletinsTable(): void
    {
        $table = "CREATE TABLE IF NOT EXISTS web.bulletins
        (
            id int auto_increment unique,
            email varchar(255) not null,
            title varchar(255) not null,
            description mediumtext not null,
            category varchar(255) not null,
            created datetime not null default NOW(),
            constraint ad_pk
                primary key (id)
        )";

        $this->db->query($table);
    }

    public function createCategoriesTable(): void
    {
        $table = "CREATE TABLE IF NOT EXISTS web.categories
        (
            id int auto_increment unique,
            category varchar(255) not null,
            constraint ad_pk
                primary key (id)
        )";

        $this->db->query($table);
    }

    public function addNewBulletin($newBulletin): void
    {
        $table = "INSERT INTO bulletins(email, title, description, category) VALUES
        (
            '{$newBulletin->getEmail()}',
            '{$newBulletin->getTitle()}',
            '{$newBulletin->getDescription()}',
            '{$newBulletin->getCategory()}'
        )";
        $this->db->query($table);
    }

    public function getBulletins(): mysqli_result|bool
    {
        $query = "SELECT * FROM bulletins";
        $bulletinsFetched = $this->db->query($query);
        return $bulletinsFetched;
    }

    public function areCategoriesEmpty(): bool
    {
        return empty($this->getCategories());
    }

    public function getCategories(): array
    {
        $categories = array();
        $query = "SELECT * FROM categories";
        $result = $this->db->query($query);


        while ($row = $result->fetch_array(MYSQLI_ASSOC))
            array_push($categories, $row['category']);

        return $categories;
    }

    public function addNewCategory($newCategory): void
    {
        $query = "INSERT INTO categories (category) VALUES ('$newCategory')";
        $this->db->query($query);
    }
}