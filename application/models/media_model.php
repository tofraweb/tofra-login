<?php
Class Media_model extends CI_Model
{

    function get_catalog_count($category = null, $search = null){
        $category = strtolower($category);
    //    include("connection.php");
        try {
            $sql = "SELECT COUNT(media_id) FROM Media";
            if(!empty($search)){
                $result = $this->db->prepare($sql
                    . " WHERE title LIKE ?"
                );
                $result->bindValue(1,'%'.$search.'%',PDO::PARAM_STR);
            }elseif(!empty($category)){
                $result = $this->db->prepare($sql
                    . " WHERE LOWER(category) = ? ");
                $result->bindParam(1,$category,PDO::PARAM_STR);
            }else{
                $result = $this->db->prepare($sql);
            }
            $result->execute();
        } catch(Exception $e){
            echo "Error in sql query";
            exit;
        }
        $count = $result->fetchColumn(0); //check fetchColumn(0)!!!!!!
        return $count;
    }

    function full_catalog_array($limit = null, $offset = 0){
    //    include("connection.php");
        try{
            $sql = "SELECT media_id,title, category, img
            FROM Media
            ORDER BY REPLACE(REPLACE(REPLACE(title,'The ',''), 'An ' , ''), 'A ', '')";
            if(is_integer($limit)){
                $results = $this->db->prepare($sql . " LIMIT ? OFFSET ? ");
                $results->bindParam(1,$limit,PDO::PARAM_INT);
                $results->bindParam(2,$offset,PDO::PARAM_INT);
            }else{
                $results = $this->db->prepare($sql);
            }
            $results->execute();
        }catch(Exception $e){
            echo "Unable to retrieve results";
            var_dump($results);
            exit;
        }
        $catalog = $results->fetchAll();
        return $catalog;
    }

    function random_catalog_array(){
     //   include("connection.php");
        try{ //pulling only 4 random items from the DB
            $results = $this->db->query(
                "SELECT media_id,title, category, img
       FROM Media
       ORDER BY RAND()
       LIMIT 4"
            );
        }catch(Exception $e){
            echo "Unable to retrieve results";
        }
        //returning results as array with keys as number (FETCH_NUM) or assoc names (FETCH_ASSOC)
        $catalog = $results->fetchAll();
        return $catalog;
    }

    function category_catalog_array($category, $limit = null, $offset = 0){
     //   include("connection.php");
        $category = strtolower($category);
        try{
            $sql = "SELECT media_id,title, category, img
      FROM Media
      WHERE LOWER(category) = ?
      ORDER BY REPLACE(REPLACE(REPLACE(title,'The ',''), 'An ' , ''), 'A ', '')";
            if(is_integer($limit)){
                $results = $this->db->prepare($sql." LIMIT ? OFFSET ? ");
                $results->bindParam(1,$category,PDO::PARAM_INT);
                $results->bindParam(2,$limit,PDO::PARAM_INT);
                $results->bindParam(3,$offset,PDO::PARAM_INT);
            }else{
                $results = $this->db->prepare($sql);
                $results->bindParam(1,$offset,PDO::PARAM_INT);
            }
            $results->execute();
        }catch(Exception $e){
            echo "Unable to retrieve results";
            exit;
        }
        $catalog = $results->fetchAll();
        return $catalog;
    }


    function search_catalog_array($search, $limit = null, $offset = 0){
      //  include("connection.php");
        try{
            $sql = "SELECT media_id,title, category, img
      FROM Media
      WHERE title LIKE ?
      ORDER BY REPLACE(REPLACE(REPLACE(title,'The ',''), 'An ' , ''), 'A ', '')";
            if(is_integer($limit)){
                $results = $this->db->prepare($sql." LIMIT ? OFFSET ? ");
                $results->bindValue(1,'%'.$search.'%',PDO::PARAM_STR);
                $results->bindParam(2,$limit,PDO::PARAM_INT);
                $results->bindParam(3,$offset,PDO::PARAM_INT);
            }else{
                $results = $this->db->prepare($sql);
                $results->bindValue(1,'%'.$search.'%',PDO::PARAM_STR);
            }
            $results->execute();
        }catch(Exception $e){
            echo "Unable to retrieve results";
            exit;
        }
        $catalog = $results->fetchAll();
        return $catalog;
    }

    function single_item_array($id){
       // include("connection.php");
        try{
            //Execute a prepared statement with question mark placeholders
            $results = $this->db->prepare(
                "SELECT title, category, img, format, year, genre, publisher, isbn
      FROM Media
      JOIN Genres ON Media.genre_id = Genres.genre_id
      LEFT OUTER JOIN Books ON Media.media_id = Books.media_id
      WHERE Media.media_id = ?"
            ); //
            $results->bindParam(1,$id,PDO::PARAM_INT); //binds an intiger parameter to the placeholder
            $results->execute();

        }catch(Exception $e){
            echo "Unable to retrieve results";
        }
        //returning results as array with keys as number (FETCH_NUM) or assoc names (FETCH_ASSOC)
        $item = $results->fetch();
        if(empty($item)) return $item;

        try{ //retrieving data about peoples (multidimensional array, see data.php)
            $results = $this->db->prepare(
                "SELECT fullname, role
      FROM Media_People
      JOIN People ON Media_People.people_id = People.people_id
      WHERE Media_People.media_id = ?"
            ); //
            $results->bindParam(1,$id,PDO::PARAM_INT);
            $results->execute();

        }catch(Exception $e){
            echo "Unable to retrieve results";
        }
        while($row = $results->fetch(PDO::FETCH_ASSOC)){
            //assigning people to different roles depending on media genre
            $item[$row["role"]][] = $row["fullname"];//need to fully understand !!!!!!!!!!!!!!!!
        }
        return $item;
    }

    function full_genre_array($category = null){
        $category = strtolower($category);
      //  include("connection.php");
        try{
            $sql = "SELECT genre, category"
                . " FROM Genres "
                . " JOIN Genre_Categories "
                . " ON Genres.genre_id = Genre_Categories.genre_id ";
            if(!empty($category)){
                $results = $this->db->prepare($sql
                    ." WHERE LOWER(category) = ?"
                    ." ORDER BY genre");
                $results->bindParam(1,$category,PDO::PARAM_STR);
            }else{
                $results = $this->db->prepare($sql ." ORDER BY genre");
            }
            $results->execute();
        }catch(Exception $e){
            echo "Unable to retrieve results";
            exit;
        }
        $genres = array();
        while($row = $results->fetch(PDO::FETCH_ASSOC)){
            //check explanation video - 05:46 min
            //https://teamtreehouse.com/library/integrating-php-with-databases/limiting-records-in-sql/simplifying-with-a-function
            $genres[$row["category"]][] = $row["genre"];
        }
        return $genres;
    }


    function get_item_html($item){
        $output = "<li><a href='details.php?id="
            .$item["media_id"]. "'><img src='"
            .$item["img"]."' alt='"
            .$item["title"]."'>"
            .'<a href = "details.php?id='.$item["media_id"].'">View Details</a>'
            . "</a></li>";
        return $output;
    }
}
