<?php
class News {
    private $id;
    private $title;
    private $content;
    private $date;

    private $img;
    private $status;
    private $account_id;

    private $conn;

    public function __construct(mysqli $db){
        $this->conn = $db;
    }

    //Getter / Setter
    public function setId($id)              { $this->id = $id; }
    public function setTitle($title)        { $this->title = $title; }
    public function setContent($content)    { $this->content = $content; }
    public function setDate($date)          { $this->date = $date; }
    public function setImg($img)            { $this->img = $img; }
    public function setStatus($status)      { $this->status = $status; }
    public function setAccount($account)    { $this->account_id = $account; }
    
    public function getId()         { return $this->id; }
    public function getTitle()      { return $this->title; }
    public function getContent()    { return $this->content; }
    public function getDate()       { return $this->date; }
    public function getImg()        { return $this->img; }
    public function getStatus()     { return $this->status; }
    public function getAccount()    { return $this->account_id; }

    //publish()
    public function publish(){
        $sql= "INSERT INTO tbl_new
                (New_Title, New_Content, New_Img, New_PublishDate, New_Status, Account_ID)
                VALUES (?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssssii",
            $this->title,
            $this->content,
            $this->img,
            $this->date,
            $this->status,
            $this->account_id
        );

        return $stmt->execute();
    }

    //edit()
    public function edit(){

        $sql = "UPDATE tbl_new
                SET New_Title=?, New_Content=?, New_Img=?, New_Status=?
                WHERE New_ID=?";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssii",
            $this->title,
            $this->content,
            $this->img,
            $this->status,
            $this->id
        );

        return $stmt->execute();
    }

    //Lấy danh sách tin
    public function getAll(){
        $sql = "SELECT * FROM tbl_new ORDER BY New_PublishDate DESC";

        return $this->conn->query($sql);
    }

    //Xóa
    public function delete(){
        $sql = "DELETE FROM tbl_new WHERE New_ID=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$this->id);

        return $stmt->execute();
    }
    public function getByCategory($category) {
    $sql = "SELECT * FROM tbl_new WHERE New_Category = ? AND New_Status = 'Publish' ORDER BY New_PublishDate DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    return $stmt->get_result();
}
    // ✅ THÊM VÀO News.php
    public function getById($id) {
    $sql = "SELECT * FROM tbl_new WHERE New_ID = ? AND New_Status = 'Publish'";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
}
?>
