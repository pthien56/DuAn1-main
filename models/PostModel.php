<?php

class PostModel extends BaseModel
{
    /**
     * Lấy tất cả bài viết
     */
    public function getAllPosts($status = null, $limit = null, $offset = 0)
    {
        $sql = "SELECT p.*, pc.name as category_name 
                FROM posts p 
                LEFT JOIN post_categories pc ON p.category_id = pc.category_id";

        if ($status) {
            $sql .= " WHERE p.status = :status";
        }

        $sql .= " ORDER BY p.created_at DESC";

        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->conn->prepare($sql);

        if ($status) {
            $stmt->bindParam(':status', $status);
        }
        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy bài viết đã xuất bản
     */
    public function getPublishedPosts($limit = 10, $offset = 0)
    {
        return $this->getAllPosts('published', $limit, $offset);
    }

    /**
     * Lấy bài viết nổi bật
     */
    public function getFeaturedPosts($limit = 5)
    {
        $sql = "SELECT p.*, pc.name as category_name 
                FROM posts p 
                LEFT JOIN post_categories pc ON p.category_id = pc.category_id
                WHERE p.status = 'published' AND p.is_featured = 1
                ORDER BY p.published_at DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy bài viết theo ID
     */
    public function getPostById($id)
    {
        $sql = "SELECT p.*, pc.name as category_name 
                FROM posts p 
                LEFT JOIN post_categories pc ON p.category_id = pc.category_id
                WHERE p.post_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy bài viết theo slug
     */
    public function getPostBySlug($slug)
    {
        $sql = "SELECT p.*, pc.name as category_name 
                FROM posts p 
                LEFT JOIN post_categories pc ON p.category_id = pc.category_id
                WHERE p.slug = :slug";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy bài viết theo danh mục
     */
    public function getPostsByCategory($categoryId, $limit = 10, $offset = 0)
    {
        $sql = "SELECT p.*, pc.name as category_name 
                FROM posts p 
                LEFT JOIN post_categories pc ON p.category_id = pc.category_id
                WHERE p.category_id = :category_id AND p.status = 'published'
                ORDER BY p.published_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tổng số bài viết
     */
    public function countPosts($status = null)
    {
        $sql = "SELECT COUNT(*) as total FROM posts";
        if ($status) {
            $sql .= " WHERE status = :status";
        }

        $stmt = $this->conn->prepare($sql);
        if ($status) {
            $stmt->bindParam(':status', $status);
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Tạo bài viết mới
     */
    public function createPost($data)
    {
        $sql = "INSERT INTO posts (title, slug, excerpt, content, thumbnail, category_id, author_id, status, is_featured, published_at) 
                VALUES (:title, :slug, :excerpt, :content, :thumbnail, :category_id, :author_id, :status, :is_featured, :published_at)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':excerpt', $data['excerpt']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':thumbnail', $data['thumbnail']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':author_id', $data['author_id']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':is_featured', $data['is_featured']);
        $stmt->bindParam(':published_at', $data['published_at']);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    /**
     * Cập nhật bài viết
     */
    public function updatePost($id, $data)
    {
        $sql = "UPDATE posts SET 
                title = :title, 
                slug = :slug, 
                excerpt = :excerpt, 
                content = :content, 
                thumbnail = :thumbnail,
                category_id = :category_id, 
                status = :status, 
                is_featured = :is_featured,
                published_at = :published_at
                WHERE post_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':excerpt', $data['excerpt']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':thumbnail', $data['thumbnail']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':is_featured', $data['is_featured']);
        $stmt->bindParam(':published_at', $data['published_at']);

        return $stmt->execute();
    }

    /**
     * Xóa bài viết
     */
    public function deletePost($id)
    {
        $sql = "DELETE FROM posts WHERE post_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Tăng lượt xem
     */
    public function incrementViewCount($id)
    {
        $sql = "UPDATE posts SET view_count = view_count + 1 WHERE post_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Tạo slug từ title
     */
    public function generateSlug($title)
    {
        $slug = $this->vietnameseToSlug($title);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Kiểm tra slug đã tồn tại
     */
    public function slugExists($slug, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM posts WHERE slug = :slug";
        if ($excludeId) {
            $sql .= " AND post_id != :exclude_id";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        if ($excludeId) {
            $stmt->bindParam(':exclude_id', $excludeId);
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    /**
     * Chuyển tiếng Việt sang slug
     */
    private function vietnameseToSlug($str)
    {
        $str = trim(mb_strtolower($str, 'UTF-8'));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/u', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/u', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/u', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/u', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/u', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/u', 'y', $str);
        $str = preg_replace('/(đ)/u', 'd', $str);
        $str = preg_replace('/[^a-z0-9\s-]/', '', $str);
        $str = preg_replace('/[\s-]+/', '-', $str);
        $str = trim($str, '-');
        return $str;
    }

    // ========== DANH MỤC BÀI VIẾT ==========

    /**
     * Lấy tất cả danh mục
     */
    public function getAllCategories()
    {
        $sql = "SELECT pc.*, COUNT(p.post_id) as post_count 
                FROM post_categories pc 
                LEFT JOIN posts p ON pc.category_id = p.category_id AND p.status = 'published'
                GROUP BY pc.category_id
                ORDER BY pc.name";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh mục theo ID
     */
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM post_categories WHERE category_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh mục theo slug
     */
    public function getCategoryBySlug($slug)
    {
        $sql = "SELECT * FROM post_categories WHERE slug = :slug";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo danh mục mới
     */
    public function createCategory($data)
    {
        $sql = "INSERT INTO post_categories (name, slug, description) VALUES (:name, :slug, :description)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':description', $data['description']);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    /**
     * Cập nhật danh mục
     */
    public function updateCategory($id, $data)
    {
        $sql = "UPDATE post_categories SET name = :name, slug = :slug, description = :description WHERE category_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':description', $data['description']);
        return $stmt->execute();
    }

    /**
     * Xóa danh mục
     */
    public function deleteCategory($id)
    {
        $sql = "DELETE FROM post_categories WHERE category_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
