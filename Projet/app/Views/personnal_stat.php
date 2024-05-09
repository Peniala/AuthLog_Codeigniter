<?php
    $ref = [
        1 => "January",
        2 => "February",
        3 => "March",
        4 => "April",
        5 => "May",
        6 => "June",
        7 => "July",
        8 => "August",
        9 => "September",
        10 => "October",
        11 => "November",
        12 => "December"
    ];
    $nextMonth = $month+1;
    $prevMonth = $month-1;
    $nextYear = $year;
    $prevYear = $year;
    if($nextMonth == 13){
        $nextMonth = 1;
        $nextYear++;
    }
    if($prevMonth == 0){
        $prevMonth = 12;
        $prevYear--;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="side_bar.css"> 
    <link rel="stylesheet" href="stat.css"> 
    <title>My Calendar</title>
</head>
<body>
    <div class="container">
        <section class="stat">
            <h3><?php if(isset($data[0]['nom']))echo $data[0]['nom']." ".$data[0]['prenoms'].' - '.$data[0]['grade'].$data[0]['niveau']; else echo "Unknown"?></h3>
            <h2><span><?php if(isset($tab)) echo count($tab)."/" ?></span><?= date("t",mktime(0,0,0,$month,1,$year)) ?></h2>
        </section>
        <table class="calendar">
            <thead>
                <tr>
                    <th><a class="nav" href="/PersonnalStat?user=<?=$user?>&year=<?=$prevYear?>&month=<?=$prevMonth?>"><</a></th>
                    <th class="title" colspan="5">
                        <nav class="barre_nav">
                            <form action="/PersonnalStat" method="GET">
                                <select name="month" required>
                                <?php
                                    foreach($ref as $i => $r){
                                ?>
                                    <option value="<?= $i;?>" <?php if(isset($month) && $month==$i) echo "selected"?> ><?= $r;?></option>
                                <?php    }
                                ?>
                                </select>
                                <input type="number" name="year" min="2023" <?php if(isset($year)) echo 'value="'.$year.'"'?>>
                                <input type="hidden" name="user" placeholder="User" <?php if(isset($user)) echo 'value="'.$user.'"'; ?>>
                                <button>Show</button>
                            </form>
                        </nav>
                    </th>
                    <th><a class="nav" href="/PersonnalStat?user=<?=$user?>&year=<?=$nextYear?>&month=<?=$nextMonth?>">></a></th>
                </tr>
                <tr>
                    <th>Lun</th>
                    <th>Mar</th>
                    <th>Mer</th>
                    <th>Jeu</th>
                    <th>Ven</th>
                    <th>Sam</th>
                    <th>Dim</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($calendar)): ?>
                    <?php if($calendar["startSpace"]): ?>
                        <tr>
                            <td class="none" colspan="<?= $calendar["startSpace"] ?>"></td>
                    <?php endif ?>

                    <?php for($i=0 ; $i<count($calendar["body"]) ; $i++): ?>
                        <?php if($i!==0 || $calendar["startSpace"]===0): ?>
                            <tr>
                        <?php endif ?>
                        <?php for($j=0 ; $j<count($calendar["body"][$i]) ; $j++): ?>
                            <td <?php if($calendar["body"][$i][$j]["state"] == 1) echo 'class="valid"'; else if($calendar["body"][$i][$j]["state"] == 2) echo 'class="today"'; ?> ><p><?= $calendar["body"][$i][$j]["value"] ?></p></td>
                        <?php endfor ?>
                        <?php if($i!==count($calendar["body"])-1 || $calendar["endSpace"]===0): ?>
                            </tr>
                        <?php endif ?>
                    <?php endfor ?>

                    <?php if($calendar["endSpace"]): ?>
                            <td class="none" colspan="<?= $calendar["endSpace"] ?>"></td>
                        </tr>
                    <?php endif ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
    <div class="side_bar">
        <div class="button_nav">
            <img src="./bars.png" alt="Bars" id="image">
        </div>
        <div class="list">
            <a href="Auth/export/0?date=<?= $year."-".$month;?>&hostname=<?= $user;?>" class="link link_pdf" target="_blank"><img class="pdf" src="file-pdf.png" alt="PDF"> Export to PDF</a>
            <a href="Auth" class="link">View session</a>
            <a href="/Dashboard" class="link">Dashboard</a>
        </div>
    </div>
    <script >
        const button_nav = document.querySelector(".button_nav");
        const image = document.querySelector("#image");
        const center = document.querySelector(".container");
        const list_nav = document.querySelector(".list");
        const side_bar = document.querySelector(".side_bar");
        const title = document.querySelector(".title");

        button_nav.addEventListener("click",()=>{
            if(list_nav.style.display === "block"){
                center.style.width = "90%";
                image.setAttribute("src","./bars.png");
                list_nav.style.display = "none";
                side_bar.style.backgroundColor = "#ececec";
                side_bar.style.width = "10%";
                title.style.marginTop = "8%";
            }
            else{
                center.style.width = "80%";
                image.setAttribute("src","./chevron-down.png");
                list_nav.style.display = "block";
                side_bar.style.backgroundColor = "#030838";
                side_bar.style.width = "20%";
                button_nav.style.backgroundColor = "#fff";
                title.style.marginTop = "12%";
            }
        });
    </script>
</body>
</html>