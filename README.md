Source Backend Hoc Mai New Version
<h3>Required</h3>
<ul>
    <li>
        Composer version >=2
    </li>
    <li>
        PHP version >= 7.4
    </li>
</ul>
<h3>PHP Extension</h3>
<ul>
    <li>
        
    </li>
    <li>
        PHP version >= 7.4
    </li>
</ul>

- Copy file .env.example thành .env
- Chạy lệnh: php artisan key:generate
- Config các biến môi trường cho APP_URL, DB Mysql, Redis, Memcache
    - Cấu hình secret key mã hóa token API, và client để Login bằng TK Google
    <p>
        <code>
            API_HOCMAI_V2_SECRET='5C576BCB289D61A2C5197975E430E4D5DA2CDEE391C187F7997AE0DEC28980BB'
        </code>
    </p>
    <p>
        <code>
            GOOGLE_CLIENT_ID=419333621048-0vqoq6v435j5k8bsi90dfm9blhdam66g.apps.googleusercontent.com
        </code>
    </p>
    <p>
        <code>
            GOOGLE_CLIENT_SECRET=1tfDPn2garu2rr1WoMTKR_al
        </code>
    </p>

- Chạy lệnh composer install
- Chạy lệnh php artisan migrate để tạo bảng, cập nhật bảng cơ sở dữ liệu


<p>
- <i>Chú ý</i> Cầm cài các extention cho redis, memcache cho phiên bản php tương ứng
</p>

<h3>Huống dẫn cài đặt fronend</h3>

<h4>Chạy fronend</h4>
    
