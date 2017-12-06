<?php
    class summaryClass{
         
        private	$sevenDays = null;
        private	$fourteenDays = null;
        private	$month = null;
        private $today = null;
         
        private $server = null;
        private $user = null;
        private $password = null;
        private $name = null;
        private $sevenSum = null;
        private $fourteenSum = null;
        private $monthSum = null;
        
        private $Sum = null;
        
 
        function __construct($server,$user,$password){
            $this->today = date("Y-m-d");
            $this->sevenDays = date('Y-m-d', strtotime('-7 days'));
            $this->fourteenDays = date('Y-m-d', strtotime('-14 days'));
            $this->month = date('Y-m-d', strtotime('-1 month'));
            
            $this->server = $server;
            $this->user = $user;
            $this->password = $password;
        }
        
        public function getSeven($productName){
            $pdo = new PDO($this->server, $this->user, $this->password);       
            $sql = "select sum([QuantityBought]) AS Total
            from [Orders]
            inner join [Days] on [Orders].[OrderNo] = [Days].[Order Number]
            WHERE [Date] > '".$this->sevenDays."' AND [NameOfItem] = '".$productName."'";
            
            $query = $pdo->prepare($sql);
            $query->execute();
            
            for($i=0; $row = $query->fetch(); $i++){
                $this->sevenSum = round($row['Total'],2);
            }
            
            return $this->sevenSum;
        }
        
        public function getMonthAdv($productName){
            $pdo = new PDO($this->server, $this->user, $this->password);
            
            $sql = "select sum([QuantityBought]) AS Total
            from [Orders]
            inner join [Days] on [Orders].[OrderNo] = [Days].[Order Number]
            WHERE [Date] > '".$this->month."' AND [NameOfItem] = '".$productName."'";
            
            $query = $pdo->prepare($sql);
            $query->execute();
            
            for($i=0; $row = $query->fetch(); $i++){
                $this->sevenSum = round($row['Total']/4,2);
            }
            
            return $this->sevenSum;
        }

        public function getFourteen($productName){
            $pdo = new PDO($this->server, $this->user, $this->password);       
            $sql = "select sum([QuantityBought]) AS Total
            from [Orders]
            inner join [Days] on [Orders].[OrderNo] = [Days].[Order Number]
            WHERE [Date] > '".$this->fourteenDays."' AND [NameOfItem] = '".$productName."'";
            
            $query = $pdo->prepare($sql);
            $query->execute();
            
            for($i=0; $row = $query->fetch(); $i++){
                $this->fourteenSum = round($row['Total'],2);
            }
            
            return $this->fourteenSum;
        }

         public function getMonth($productName){
            $pdo = new PDO($this->server, $this->user, $this->password);       
            $sql = "select sum([QuantityBought]) AS Total
            from [Orders]
            inner join [Days] on [Orders].[OrderNo] = [Days].[Order Number]
            WHERE [Date] > '".$this->month."' AND [NameOfItem] = '".$productName."'";
            
            $query = $pdo->prepare($sql);
            $query->execute();
            
            for($i=0; $row = $query->fetch(); $i++){
                $this->monthSum = round($row['Total'],2);
            }
            
            return $this->monthSum;
        }
        
        public function getMin($productName,$minProc,$packSize){
            $this->Sum = $this->getMonthAdv($productName);
            $min = round(($this->Sum - ($minProc*$this->Sum)/100),0);
           // $min = round($this->Sum,0);

            if($min == 0 OR $min == 1){
                $min = 2;
            }
            
            return $min;
        }
        
        public function getMax($productName,$maxProc,$packSize){
            $this->Sum = $this->getMonthAdv($productName);
            $max = round(($this->Sum + ($maxProc*$this->Sum)/100),0);

            if($max == 0 OR $max == 1){
                $max = 2;
            }
            
            
            
            while ($max%$packSize != 0){
                $max++;
            }
            
            return $max;
        }
        
    }
?>