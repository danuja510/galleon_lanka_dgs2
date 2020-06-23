<?php
 session_start();
 if(!isset($_SESSION['eno'])){
   header('Location:signIn.php');
 }
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" type="text/css" href="../Resources/CSS/normalize.css">
     <link rel="stylesheet" type="text/css" href="../Resources/CSS/grid.css">
     <link rel="stylesheet" type="text/css" href="../Resources/CSS/ionicons.min.css">
     <link rel="stylesheet" type="text/css" href="../StyleSheets/MainStyles.css">
     <link rel="stylesheet" type="text/css" href="../StyleSheets/HomeStyles.css">
     <link href="https://fonts.googleapis.com/css?family=Lato:100,300,300i,400&display=swap" rel="stylesheet">
     <title>EmployeeHome</title>
   </head>
   <body>
    <header>
        <div class="row">
            <h1>Manufacturing Management System</h1>
            <h3>Galleon Lanka PLC</h3>
        </div>
        <div class="nav">
          <div class="row">
            <!--<div class="btn-navi">
              <i class="ion-navicon-round"></i>
            </div>-->
            <a href="empHome.php">
              <div class="btn-home">
                <i class="ion-home"></i>
                <p>Home</p>
              </div>
            </a>
              <a href="logout.php">
                <div class="btn-logout">
                  <i class="ion-log-out"></i>
                  <p>Logout</p>
                </div>
              </a>
              <a href="userProfile.php">
                <div class="btn-account">
                    <i class="ion-ios-person"></i>
                    <p>Account</p>
                </div>
              </a>
          </div>
        </div>
    </header>
    <section class="section-select">
        <?php
            $purchaseOrders="
              <div class='col span-1-of-4'>
                  <a href='viewPurchaseOrders.php'>
                      <div class='select-option'>
                          <i class='ion-ios-paper-outline icon-select'></i>
                          <h4>Manage Purchase Orders</h4>
                      </div>
                  </a>
              </div>
              ";
            $grn="
              <div class='col span-1-of-4'>
                  <a href='viewGRN.php'>
                      <div class='select-option'>
                          <i class='ion-ios-paper-outline icon-select'></i>
                          <h4>Manage GRNs</h4>
                      </div>
                  </a>
              </div>";
            $gtn="
            <div class='col span-1-of-4'>
                <a href='manageGTN.php'>
                    <div class='select-option'>
                        <i class='ion-arrow-swap icon-select'></i>
                        <h4>Manage Goods Transfers</h4>
                    </div>
                </a>
            </div>";
            $invoice="
              <div class='col span-1-of-4'>
                  <a href='manageInvoices.php'>
                      <div class='select-option'>
                          <i class='ion-ios-paper-outline icon-select'></i>
                          <h4>Manage Invoices</h4>
                      </div>
                  </a>
              </div>";
            $paymentVoucher="
              <div class='col span-1-of-4'>
                  <a href='viewPaymentVoucher.php'>
                      <div class='select-option'>
                          <i class='ion-ios-paper-outline icon-select'></i>
                          <h4>Manage Payment Vouchers</h4>
                      </div>
                  </a>
              </div>";
            $cashReceipt="
              <div class='col span-1-of-4'>
                  <a href='viewCashreceipt.php'>
                      <div class='select-option'>
                          <i class='ion-ios-paper-outline icon-select'></i>
                          <h4>Manage Cash Receipts</h4>
                      </div>
                  </a>
              </div>";
            $finishedProducts="
              <div class='col span-1-of-4'>
                  <a href='viewFinishedProducts.php'>
                      <div class='select-option'>
                          <i class='ion-ios-star icon-select'></i>
                          <h4>Manage Finished Products</h4>
                      </div>
                  </a>
              </div>";
            $materials="
                <div class='col span-1-of-4'>
                    <a href='viewMaterials.php'>
                        <div class='select-option'>
                            <i class='ion-ios-star-outline icon-select'></i>
                            <h4>Manage Materials</h4>
                        </div>
                    </a>
                </div>";
            $suppliers="
              <div class='col span-1-of-4'>
                  <a href='viewSuppliers.php'>
                      <div class='select-option'>
                          <i class='ion-ios-person-outline icon-select'></i>
                          <h4>Manage Suppliers</h4>
                      </div>
                  </a>
              </div>";
            $customers="
              <div class='col span-1-of-4'>
                  <a href='viewCustomer.php'>
                      <div class='select-option'>
                          <i class='ion-ios-person-outline icon-select'></i>
                          <h4>Manage Customers</h4>
                      </div>
                  </a>
              </div>";
            $bom="
                <div class='col span-1-of-4'>
                    <a href='manageBOM.php'>
                        <div class='select-option'>
                            <i class='ion-ios-color-filter-outline icon-select'></i>
                            <h4>Manage BOMs</h4>
                        </div>
                    </a>
                </div>";
            $stocks="
              <div class='col span-1-of-4'>
                  <a href='viewStocks.php'>
                      <div class='select-option'>
                          <i class='ion-clipboard icon-select'></i>
                          <h4>View Stock</h4>
                      </div>
                  </a>
              </div>";
            $efficiency="
                <div class='col span-1-of-4'>
                    <a href='selectEf.php'>
                        <div class='select-option'>
                            <i class='ion-arrow-graph-up-right icon-select'></i>
                            <h4>View State</h4>
                        </div>
                    </a>
                </div>";
            $creditors="
              <div class='col span-1-of-4'>
                  <a href='viewCreditors.php'>
                      <div class='select-option'>
                          <i class='ion-ios-person-outline icon-select'></i>
                          <h4>View Creditors</h4>
                      </div>
                  </a>
              </div>";
            $debtors="
              <div class='col span-1-of-4'>
                  <a href='viewDebtors.php'>
                      <div class='select-option'>
                          <i class='ion-ios-person-outline icon-select'></i>
                          <h4>View Debtors</h4>
                      </div>
                  </a>
              </div>";

            $employees="
            <div class='col span-1-of-4'>
                <a href='viewEmployees.php'>
                    <div class='select-option'>
                        <i class='ion-ios-person-outline icon-select'></i>
                        <h4>Manage Employees</h4>
                    </div>
                </a>
            </div>";
        ?>
        <div class="row">
          <?php
            switch ($_SESSION['DEPT']) {
              case 'Manager':
                echo $purchaseOrders.$grn.$gtn.$invoice;
                break;

              case 'store':
                echo $purchaseOrders.$grn.$gtn.$paymentVoucher;
                break;

              case 'pFloor':
                echo $gtn.$materials.$finishedProducts.$stocks;
                break;

              case 'fGoods':
                echo $gtn.$invoice.$cashReceipt.$stocks;
                break;
            }
          ?>
        </div>
        <div class="row">
          <?php
          switch ($_SESSION['DEPT']) {
            case 'Manager':
              echo $paymentVoucher.$cashReceipt.$stocks.$employees;
              break;

            case 'store':
              echo $stocks.$materials.$suppliers;
              break;

            case 'fGoods':
              echo $customers;
              break;
          }
          ?>
        </div>
        <div class="row">
            <?php
            switch ($_SESSION['DEPT']) {
              case 'Manager':
                echo $efficiency.$creditors.$debtors.$bom;
                break;
            }
            ?>
        </div>
        <div class="row">
          <?php

          switch ($_SESSION['DEPT']) {
            case 'Manager':
              echo $materials.$finishedProducts.$suppliers.$customers;
              break;
          }
            ?>
        </div>
    </section>
    <footer>
        <div class="row">
                <p> Copyright &copy; 2020 by Galleon Lanka PLC. All rights reserved.</p>
        </div>
        <div class="row">
                <p>Designed and Developed by DGS2</p>
        </div>
    </footer>
   </body>
 </html>
 <!--dan-->
