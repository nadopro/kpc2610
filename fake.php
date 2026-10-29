<?php
    if(isset($_POST["num"]))
    {
        $num = $_POST["num"];
    }else
    {
        $num = 10;
    }
?>
<form method="post" action="index.php?cmd=fake">
    <div class="row">
        <div class="col-2 text-end">횟수</div>
        <div class="col">
            <input type="number" name="num"  class="form-control" value="<?php echo $num?>" min="6" max="10000000" step="1">
        </div>
        <div class="col-2 text-end">
            <button type="submit" class='btn btn-primary'>실행</button>
        </div>
    </div>
</form>

<?php
    if(isset($_POST["num"]))
    {
 

        $name1 = "김,김,김,박,박,이,이,정,최,한,민,오,선우,독고,선,우,오,하,고";
        $name2 = "찬,학,경,태,유,희,아,권,홍";
        $name3 = "호,재,한,빈,숙,중,재,철";

        $gen = "1,1,1,1,1,1,1,2,2,2";
        $dis = "0,0,0,0,0,0,0,0,0,1";
        
        $sn1 = explode(",", $name1);
        $sn2 = explode(",", $name3);
        $sn3 = explode(",", $name3);
        $sgen = explode(",", $gen);
        $sdis = explode(",", $dis);

        $c1 = count($sn1);
        $c2 = count($sn2);
        $c3 = count($sn3);

        $cgen = count($sgen);
        $cdis = count($sdis);

        ?>
        <table class='table table-bordered'>
            <tr>
                <td>순서</td>
                <td>이름</td>
                <td>성별</td>
                <td>장애여부</td>
            </tr>
        <?php
            for($i=1; $i<=$num; $i++)
            {
                $rand1 = rand(0, $c1 -1);
                $rand2 = rand(0, $c2 -1);
                $rand3 = rand(0, $c3 -1);

                $randGender = rand(1,2);
                $randDisabled = rand(0,1);

                if($randGender == 1)
                    $gender = "남";
                else
                    $gender = "여";

                if($randDisabled == 1)
                    $disabled = "장애인";
                else
                    $disabled = "-";

                $name = $sn1[$rand1] . $sn2[$rand2] . $sn3[$rand3];

                echo "
                <tr>
                    <td>$i</td>
                    <td>$name</td>
                    <td>$gender</td>
                    <td>$disabled</td>
                </tr>";

            }
        
        ?>
        </table>
        <?php
    }
?>