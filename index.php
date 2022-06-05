<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Find a Hospital</title>
        <link rel="stylesheet" type="text/css" href="style.css"/>

        <link rel="stylesheet"
        href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700;800;900&display=swap" rel="stylesheet">   

    </head>
    <body>
        <?php
        require_once("sparqllib.php");
        $test = "";
        if (isset($_POST['search-rs'])) {
          $test = $_POST['search-rs'];
          $data = sparql_get(
            "http://localhost:3030/dataRumahSakit",
            "
            prefix ab: <http://learningsparql.com/ns/addressbook#> 
            prefix d:  <http://learningsparql.com/ns/data#> 
            prefix media: <https://www.ldf.fi/service/rdf-grapher> 
      
            SELECT ?nama ?alamat ?notelp ?email ?wilayah ?jenis ?ket ?pasien 
            WHERE
            {
              ?d  ab:nama ?nama;
                  ab:alamat ?alamat ;
                  ab:notelp ?notelp ;
                  ab:email ?email ;
                  ab:wilayah ?wilayah ;
                  ab:jenis ?jenis ;
                  ab:ket ?ket ;
                  ab:pasien ?pasien . 
                  FILTER (regex (?nama,  '$test', 'i') || regex (?alamat,  '$test', 'i') || regex (?notelp,  '$test', 'i') || regex (?email,  '$test', 'i') || regex (?wilayah,  '$test', 'i') || regex (?jenis,  '$test', 'i') || regex (?ket,  '$test', 'i') || regex (?pasien,  '$test', 'i'))
              }"
          );
        } else {
          $data = sparql_get(
            "http://localhost:3030/dataRumahSakit",
            "
            prefix ab: <http://learningsparql.com/ns/addressbook#> 
            prefix d:  <http://learningsparql.com/ns/data#> 
            prefix media: <https://www.ldf.fi/service/rdf-grapher> 

            SELECT ?nama ?alamat ?notelp ?email ?wilayah ?jenis ?ket ?pasien
              WHERE
              { 
                  ?d  
                  ab:nama ?nama;
                  ab:alamat ?alamat ;
                  ab:notelp ?notelp ;
                  ab:email ?email ;
                  ab:wilayah ?wilayah ;
                  ab:jenis ?jenis ;
                  ab:ket ?ket ;
                  ab:pasien ?pasien.        
              }
                  "
          );
        }
      
        if (!isset($data)) {
          print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
        }
      
        ?>

        <header>
            <a href="#home" class="logo">Hospitals</a>
            <div class="bx bx-menu" id="menu-icon"></div>

            <ul class="navbar">
                <li><a href="#home">Home</a></li>
                <li><a href="#search">Find</a></li>
            </ul>
        </header>

         <!-- Home Section -->
        <section class="home" id="home">
            <div class="home-text">
                <h1>Find a Hospital</h1>
                <h2>Make It Easier To Find <br> Hospital Information <br> In Jakarta</h2>
                <a href="#search" class="btn">Search</a>
            </div>

            <div class="home-img">
                <img src="img/home.png">
            </div>
        </section>

        <!-- Search Section -->
        <section class="search" id="search">
            <div class="search">
                <h2>Find Your Hospital</h2>
                
                <div class="wrapper">
                    <div class="search_box">
                        <form action="" method="post" id="search-rs">
                            <input type="text" class="input_search" placeholder="What are you looking for?" name="search-rs">
                            <button type="submit" class="search_btn"><i class='bx bx-search'></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Result Section -->
        <section class="result" id="result">
        <div class="row text-center mb-3 hasil">
          <div class="col">
            <h2>Search Result</h2>
          </div>
        </div>
        <div class="row fs-5">
          <div class="col-md-5">
            <p>
           - Showing Search For -
            </p>
            <p>
              <span>
          <?php
          if ($test != NULL) {
            echo $test;
          } else {
            echo "  Rumah Sakit yang dicari :";
          }
          ?></span>
            </p>
          </div>
        </div>
          
        <div class="row">

        <?php $i = 0; ?>
        <?php foreach ($data as $datas ): ?>
        <div class="col-md-4">
        <div class="box"> 
        <br>
        <ul class="list-group list-group-flush" style="border: 10px;">

        <div class="header-data"> <b>Hospital Name :</b></div>
        <div class="item-data"><?= $datas['nama']; ?></div>
  
        <div class="header-data"> <b>Address :</b></div>
        <div class="item-data"><?= $datas['alamat']; ?></div>
        
        <div class="header-data"> <b>No. Handphone :</b></div>
        <div class="item-data"><?= $datas['notelp']; ?></div>

        <div class="header-data"> <b>Email :</b></div>
        <div class="item-data"><?= $datas['email']; ?></div>

        <div class="header-data"> <b>Region :</b></div>
        <div class="item-data"><?= $datas['wilayah']; ?></div>

        <div class="header-data"> <b>Hospital Type :</b></div>
        <div class="item-data"><?= $datas['jenis']; ?></div>

        <div class="header-data"> <b>Description :</b></div>
        <div class="item-data"><?= $datas['ket']; ?></div>

        <div class="header-data"> <b>Number of Patients / Month :</b></div>
        <div class="item-data"><?= $datas['pasien']; ?></div>
      </ul>
    </div>
  </div>
 <?php endforeach; ?>
</div>

        </section>

         <!-- Footer Section -->
         <footer>
             <div class="footer-content">
                 <h3>Find Your Hospital</h3>
             </div>
             <div class="footer-bottom">
                 <p>copyright &copy;2022 FindHospital. designed by <span>Yuela Thahira - 140810190064</span></p>
             </div>
         </footer>

    </body>
</html>