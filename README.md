# Thực hành: QUẢN TRỊ MẠNG LƯỚI WORDPRESS MULTISITE

**Thông tin sinh viên:**
* **Họ và tên:** Ngô Đức Dũng
* **Mã sinh viên:** 23810310264

---

##  Mục tiêu bài tập
1. Cấu hình và quản trị mạng lưới website WordPress Multisite theo cấu trúc Sub-directories.
2. Thực hành cấu hình can thiệp hệ thống qua file `wp-config.php` và `.htaccess`.
3. Viết và triển khai Plugin **Network Site Stats** có khả năng hoạt động trên toàn mạng lưới (Network Activated).

##  Cấu trúc Repository
Repository này chứa các tệp tin kết quả của bài thực hành:

* `network-site-stats/`: Thư mục mã nguồn của plugin hiển thị bảng thống kê các site con.
* `ngoducdung.sql`: File backup cơ sở dữ liệu (Database) chứng minh hệ thống đã thay đổi cấu trúc bảng cho Multisite (chứa các bảng `wp_2_posts`, `wp_3_posts`...).
* `Báo Cáo Thực Hành.docx`: File báo cáo chi tiết kèm ảnh chụp màn hình minh chứng các bước thực hiện và giải thích mã nguồn.

##  Hướng dẫn kiểm tra Plugin (Dành cho người chấm)
1. Cài đặt hệ thống WordPress Multisite (Sub-directories).
2. Copy thư mục `network-site-stats` vào đường dẫn `wp-content/plugins/`.
3. Đăng nhập với quyền **Super Admin**.
4. Truy cập **Network Admin Dashboard > Plugins** và nhấn **Network Activate** cho plugin *Network Site Stats*.
5. Kiểm tra kết quả tại menu **Site Stats** (cột bên trái của Network Admin). Dữ liệu sẽ lấy động từ các site con qua hàm `switch_to_blog()`.

---
