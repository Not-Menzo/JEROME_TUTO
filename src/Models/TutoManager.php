<?php

namespace tutoAPI\Models;

use tutoAPI\Services\Manager;

class TutoManager extends Manager
{

    public function find($id)
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        // Instanciation d'un tuto
        $tuto = new Tuto();
        $tuto->setId($result["id"]);
        $tuto->setTitle($result["title"]);
        $tuto->setDescription($result["description"]);
        $tuto->setCreatedAt($result["createdAt"]);

        // Retour
        return $tuto;
    }

    public function patch($_PATCH, $id)
    {
        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('UPDATE `tutos` SET `title`= :title ,`description`= :decription ,`createdAt`= :createdAt WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->bindParam(':title', $_PATCH->title);
        $sth->bindParam(':decription', $_PATCH->description);
        $sth->bindParam(':createdAt', $_PATCH->createdAt);
        $sth->execute();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        // Instanciation d'un tuto
        $tuto = new Tuto();
        $tuto->setId($result["id"]);
        $tuto->setTitle($result["title"]);
        $tuto->setDescription($result["description"]);
        $tuto->setCreatedAt($result["createdAt"]);


        // Retour
        return $result;
    }

    public function post($_PATCH)
    {
        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sql = 'INSERT INTO `tutos` (`title`, `description`, `createdAt`) VALUES (?,?,?)';
        $sth= $dbh->prepare($sql);
        $result = $sth->execute([$_PATCH->title, $_PATCH->description, $_PATCH->createdAt]);

        // Retour
        return $result;
    }

    public function delete($id)
    {
        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sql = 'DELETE FROM `tutos` WHERE id = :id';
        $sth= $dbh->prepare($sql);
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);   
        $result = $sth->execute();

        // Retour
        return $result;
    }

    public function findAll($page=0)
    {
        $dbh = static::connectDb();
        //Pagination par page de 5 cas
        if($page==0)
        {
            $sth = $dbh->prepare('SELECT * FROM tutos');
        }
        else
        {
            $page=$page*5-5;
            $sth = $dbh->prepare('SELECT * FROM tutos LIMIT 5 OFFSET :page');
            $sth->bindParam(':page', $page, \PDO::PARAM_INT);
        }
        $sth->execute();
        $tutos = [];
        while($row = $sth->fetch(\PDO::FETCH_ASSOC)){
            $tuto = new Tuto();
            $tuto->setId($row['id']);
            $tuto->setTitle($row['title']);
            $tuto->setDescription($row['description']);
            $tuto->setCreatedAt($row["createdAt"]);
            $tutos[] = $tuto;
        }
        return $tutos;
    }

    public function add(Tuto $tuto){

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('INSERT INTO tutos (title, description, createdAt) VALUES (:title, :description, :createdAt)');
        $title = $tuto->getTitle();
        $sth->bindParam(':title', $title);
        $description = $tuto->getDescription();
        $sth->bindParam(':description', $description);
        $createdAt = $tuto->getCreatedAt();
        $sth->bindParam(':createdAt', $createdAt);
        $sth->execute();

        // Retour
        $id = $dbh->lastInsertId();
        $tuto->setId($id);
        return $tuto;

    }

    public function update(Tuto $tuto){

       // Modification d'un tuto en BDD

    }


    public function findPaginate()
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos');
        $sth->execute();

        $tutos = [];

        while($row = $sth->fetch(\PDO::FETCH_ASSOC)){

            $tuto = new Tuto();
            $tuto->setId($row['id']);
            $tuto->setTitle($row['title']);
            $tuto->setDescription($row['description']);
            $tuto->setCreatedAt($row["createdAt"]);
            $tutos[] = $tuto;

        }
        
        return $tutos;

    }

    public function findPage()
    {

        // Connexion à la BDD
        $dbh = static::connectDb();

        // Requête
        $sth = $dbh->prepare('SELECT * FROM tutos');
        $sth->execute();

        $tutos = [];

        while($row = $sth->fetch(\PDO::FETCH_ASSOC)){

            $tuto = new Tuto();
            $tuto->setId($row['id']);
            $tuto->setTitle($row['title']);
            $tuto->setDescription($row['description']);
            $tuto->setCreatedAt($row["createdAt"]);
            $tutos[] = $tuto;

        }
        
        return $tutos;

    }




}
