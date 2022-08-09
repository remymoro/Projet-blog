<?php



class ArticleDB
{
    private PDOStatement $statementCreateOne;
    private PDOStatement $statementUpdateOne;
    private PDOStatement $statementDelateOne;
    private PDOStatement $statementReadOne;
    private PDOStatement $statementReadAll;
    private PDOStatement $statementReadUserAll;
    
    
    

   function __construct(private PDO $pdo)
   {
   $this->statementCreateOne = $pdo->prepare('
    INSERT INTO articles(
        title,
        category,
        content,
        image,
        author
        )VALUES(
            :title,
            :category,
            :content,
            :image,
            :author
        )
    ');
    
    
    
  $this->statementUpdateOne =$pdo->prepare('
    UPDATE articles
    SET
            title=:title,
            category=:category,
            content=:content,
            image=:image,
            author=:author
    WHERE id=:id;
    
    ');
    
    $this->statementReadOne = $pdo->prepare('SELECT articles.* , user.firstname, user.lastname FROM articles LEFT JOIN user ON articles.author =user.id WHERE articles.id=:id');
    $this->statementReadAll = $pdo->prepare('SELECT articles.*, user.firstname ,user.lastname FROM articles LEFT JOIN user ON articles.author=user.id');
    $this->statementDelateOne = $pdo->prepare('DELETE FROM articles WHERE id=:id');
    $this->statementReadUserAll = $pdo->prepare('SELECT * FROM articles WHERE author=:authorId');
}

public function fetchAll():array
{
$this->statementReadAll->execute();
return $this->statementReadAll->fetchAll();
}

public function fetchOne(string $id): array
{
$this->statementReadOne->bindValue(':id',$id);
$this->statementReadOne->execute();
return $this->statementReadOne->fetch();
}

public function deleteOne(string $id) :string
{
$this->statementDelateOne->bindValue(':id',$id);
$this->statementDelateOne->execute();
return $id;
}

public function  createOne($articles):array
{
 $this->statementCreateOne->bindValue(':title',$articles['title']);
 $this->statementCreateOne->bindValue(':content',$articles['content']);
 $this->statementCreateOne->bindValue(':category',$articles['category']);
 $this->statementCreateOne->bindValue(':image',$articles['image']);
 $this->statementCreateOne->bindValue(':author',$articles['author']);
 $this->statementCreateOne->execute();
 return $this->fetchOne($this->pdo->lastInsertId());
}

public function  updateOne($articles) : array
{
 $this->statementUpdateOne->bindValue(':title',$articles['title']);
 $this->statementUpdateOne->bindValue(':content',$articles['content']);
 $this->statementUpdateOne->bindValue(':category',$articles['category']);
 $this->statementUpdateOne->bindValue(':image',$articles['image']);
 $this->statementUpdateOne->bindValue(':id',$articles['id']);
 $this->statementUpdateOne->bindValue(':author',$articles['author']);
 $this->statementUpdateOne->execute();
 return $articles;
}


public function fetchUserArticle(string $authorId) : array
{
 $this->statementReadUserAll->bindValue(':authorId',$authorId);
 $this->statementReadUserAll->execute();
 return $this->statementReadUserAll->fetchAll();
}

};
return new ArticleDB($pdo);
?>



     








