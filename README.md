<a name="readme-top"></a>

<div align="center">
  <h3 align="center">Social-Network</h3>
  <p>Social network platform from scratch PHP</p>
</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#license">License</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

![Screen Shot][product-screenshot-1]

Social-Network platform will let your users to connect with eachother in more friendly way. Post,like,comments,chat,follow each others and many more

<p align="right">(<a href="#readme-top">back to top</a>)</p>

### Built With

This platform built on scratch PHP using OOP PHP, PHP Design Pattern and PHP PDO Mysql and for template for frontend

* [![php][php]][php-url]
* ![mysql][mysql]

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- GETTING STARTED -->
## Getting Started

By following the instructions you can run the script on your machine

### Prerequisites

Before installing the script you need some external dependencies on your machine
* php 7.2 <

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/S4F4Y4T/Social-Network.git
   ```
2. Changin folder and files permissions 
   ```sh
   sudo find "Your project directory" -type f -exec chmod 644 {} \;
   sudo find "Your project directory" -type d -exec chmod 755 {} \;
   ```
3. Give images dir with all the sub dir permission to upload

4. Create and import the social.sql into mysql DB

5. Open config/config.php and change the db information accordingly

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Usage

After installing the project go to the project directory and regiter a new account to login into profile 

Login credentials:
  username: safayat
  password: password

Here are some screenshots:

![Screen Shot][product-screenshot-2]
![Screen Shot][product-screenshot-3]
![Screen Shot][product-screenshot-4]
![Screen Shot][product-screenshot-5]

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->

[product-screenshot-1]: overview/1.png
[product-screenshot-2]: overview/2.png
[product-screenshot-3]: overview/3.png
[product-screenshot-4]: overview/4.png
[product-screenshot-5]: overview/5.png

[php]: https://img.shields.io/badge/php-php-white
[Php-url]: https://www.php.net/
[mysql]: https://img.shields.io/badge/MYSQL-MYSQL-orange
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com 
