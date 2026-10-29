<?php

    // 접근 권한 체크

    if(!isset($_SESSION["id"]) or (isset($_SESSION['id']) and $_SESSION['level'] <9))
    {
        echo "
        <script>
            alert('접근권한이 없습니다. Error Code : 123');
            location.href='http://warning.or.kr';
        </script>
        ";
        exit;
    }


    function getDirs($path)
    {
        $dirHandler = opendir($path);

        while( ($filename = readdir($dirHandler)) != false)
        {
            if(is_dir("$path/$filename"))
            {
                $dirs[] = $filename;
            }
        }
        return $dirs;
    }

    function getFiles($path)
    {
        $fileHandler = opendir($path);

        while( ($filename = readdir($fileHandler)) != false)
        {
            if(is_dir("$path/$filename"))
            {
            }else
            {
                $files[] = $filename;
            }
        }
        return $files;        
    }

    function readFileSecure($path)
    {
        if(!$handler = fopen($path, 'r'))
        {
            return "File Open Error : $path";
        }

        $fileContents = file_get_contents($path, true);
        return $fileContents;
    }

    $sess_path = "sess_path"; // config.php

    if(!isset($_SESSION[$sess_path])) 
    {
        $_SESSION[$sess_path] = ".";
    }

    if(isset($_GET["pdir"]))
    {
        $_SESSION[$sess_path] = $_GET["pdir"]; 
    }

    if(isset($_POST["fname"]) and isset($_POST["fdata"]))
    {
        $fname = $_POST["fname"];
        $fdata = $_POST["fdata"];

        $pathFile = $_SESSION[$sess_path] . "/" . $fname;

        if(file_exists($pathFile))
        {
            unlink($pathFile);
        }

        if(!$handler = fopen($pathFile, 'w'))
        {
            echo "File Open Error for Write : $pathFile <br>";
        }

        if(fwrite($handler, $fdata) == false)
        {
            echo "File Write Error : $pathFile <br>";
        }

        echo "
        <script>
            alert('파일 생성 완료 : $fname');
            location.href='index.php?cmd=ftp';
        </script>
        ";
    }

    // index.php?cmd=ftp&pdir=./data
?>

<div class="row">
    <table class="table table-borderd">
        <tr>
            <td class="col-3">
                디렉토리
                <table class="table">
                    <tr>
                        <td><a href="index.php?cmd=ftp&pdir=.">처음으로</a></td>
                    </tr>

                    <?php
                        $dirs = getDirs($_SESSION[$sess_path]);
                        $cnt = 0;

                        while(isset($dirs[$cnt]))
                        {
                            $nextDir = $_SESSION[$sess_path] . "/" . $dirs[$cnt];
                            echo "
                            <tr>
                                <td><a href='index.php?cmd=ftp&pdir=$nextDir'>$dirs[$cnt]</a></td>
                            </tr>
                            ";
                            $cnt ++;
                        }
                    ?>
                </table>
            </td>
            <td class="col">파일목록

                <table class="table">
                    <?php
                        $files = getFiles($_SESSION[$sess_path]);
                        $cnt = 0;

                        while(isset($files[$cnt]))
                        {
        
                            echo "
                            <tr>
                                <td><a href='index.php?cmd=ftp&pfile=$files[$cnt]'>$files[$cnt]</a></td>
                            </tr>
                            ";
                            $cnt ++;
                        }
                    ?>

                </table>

            </td>
        </tr>
    </table>
</div>
<?php
    if(isset($_GET["pfile"]))
    {
        $fileContent = readFileSecure($_SESSION[$sess_path] . "/" . $_GET["pfile"]);

    }else
    {
        $fileContent = "";
    }
?>
<form method="post" action="index.php?cmd=ftp">
<div class="row">
    <div class="col">
        <textarea class="form-control" name="fdata" rows="10"><?php echo $fileContent ?></textarea>
    </div>
</div>
<div class="row">
    <div class="col-3 text-end">파일명</div>
    <div class="col">
        <input type="text" name="fname" class="form-control" placeholder="파일이름을 입력하세요">

    </div>
    <div class="col-2">
        <button type="submit" class="btn btn-sm btn-primary form-control">등록</button>
    </div>
</div>
</form>