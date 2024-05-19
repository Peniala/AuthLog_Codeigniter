<?php
	$hostname=(isset($_GET['hostname']))?$_GET['hostname']:null;
	$date=(isset($_GET['date']))?$_GET['date']:null;
	$type=(isset($_GET['type']))?$_GET['type']:null;
	$process=(isset($_GET['process']))?$_GET['process']:null;
	$user=(isset($_GET['user']))?$_GET['user']:null;
	$page=(isset($_GET['page']))?$_GET['page']:null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./body.css">
    <link rel="stylesheet" href="./table.css">
    <link rel="stylesheet" href="./pagination.css">
    <link rel="stylesheet" href="./side_bar.css">
</head>
<body>
    <nav class="barre_nav">
        <form action="/Auth">
            <input type="date" name="date" id="" <?php if(isset($date)) echo "value=\"".$date."\"" ?> >
            <input type="text" placeholder="Hostname" name="hostname" <?php if(isset($hostname)) echo "value=\"".$hostname."\"" ?>>
            <select name="type" id="" >
                <option value="">Type</option>
                <option value="opened" <?php if(isset($type) && $type == "opened") echo "selected" ?>>Opened</option>
                <option value="closed" <?php if(isset($type) && $type == "closed") echo "selected" ?>>Closed</option>
            </select>
            <!-- <input type="checkbox" name="opened" id=""><label>Opened</label>
            <input type="checkbox" name="closed" id=""><label>Closed</label> -->
            <input type="text" placeholder="Process" name="process" <?php if(isset($process)) echo "value=\"".$process."\"" ?>>                <input type="text" placeholder="User" name="user" <?php if(isset($user)) echo "value=\"".$user."\"" ?>>
            <button type="submit">Search</button>
            <a href="Auth/actualize?date=<?= $date;?>&hostname=<?= $hostname;?>&type=<?= $type;?>&process=<?= $process;?>&user=<?= $user;?>&page=<?= $page;?>" class="actu"><button type="button">Actualize</button></a>
        </form>
    </nav>
    <div class="side_bar">
            <div class="button_nav">
                <img src="./bars.png" alt="Bars" id="image">
            </div>
            <div class="list">
		<a href="Auth/export/3?date=<?= $date;?>&hostname=<?= $hostname;?>&type=<?= $type;?>&process=<?= $process;?>&user=<?= $user;?>&page=<?= $page;?>" class="link link_pdf" target="_blank"><img class="pdf" src="file-pdf.png" alt="PDF"> Export All to PDF</a> 
                <a href="Auth/export/0?date=<?= $date;?>&hostname=<?= $hostname;?>&type=<?= $type;?>&process=<?= $process;?>&user=<?= $user;?>&page=<?= $page;?>" class="link link_pdf" target="_blank"><img class="pdf" src="file-pdf.png" alt="PDF"> Export to PDF</a>
                <a href="Auth" class="actived link">View session</a>
                <a href="/Dashboard" class="link">Dashboard</a>
                <a href='/deconnexion' class="link">Log out</a>
            </div>
        </div>
    <section class="center">
        <h1 class="title">Auth.log file</h1>
            <?php if(isset($session) && is_array($session)): ?>
                <table>
                    <tr>
                        <td>Id</td>
                        <td>Date</td>
                        <td>Hostname</td>
                        <td>Process</td>
                        <td>Type</td>
                        <td>User</td>
                    </tr>
                    <?php foreach($session as $index => $row): ?>
                                <tr class="<?= ($index%2 != 0) ? "odd" : "even";?>">
                                    <?php foreach($row as $i => $col): 
                                        if($i == 'date') echo "<td><a href=\"/PersonnalStat?year=".date('Y',strtotime($row["date"]))."&month=".date('m',strtotime($row["date"]))."&user=".$row['hostname']."\">".date('d-m-Y h:i:s',strtotime($col))."</a></td>";
                                        // else if($i == 'nom') echo "<td><a href=\"/PersonnalStat?year=".date('Y',strtotime($row["date"]))."&month=".date('m',strtotime($row["date"]))."&user=".$row['hostname']."\">".$row["nom"]." ".$row["prenoms"]."</a></td>";
                                        // else if($i == 'prenoms') continue;
                                        else echo "<td><a href=\"/PersonnalStat?year=".date('Y',strtotime($row["date"]))."&month=".date('m',strtotime($row["date"]))."&user=".$row['hostname']."\">".$col."</a></td>";
                                    endforeach ?>
                                </tr>
                    <?php endforeach ?>
                    
                </table>
                <?php if ($cond == 0) echo $pager->links(); ?>
            <?php endif ?>
    </section>
    
    
    <script >
        const barre_nav = document.querySelector(".barre_nav");
        const button_nav = document.querySelector(".button_nav");
        const image = document.querySelector("#image");
        const center = document.querySelector(".center");
        const list_nav = document.querySelector(".list");
        const side_bar = document.querySelector(".side_bar");
        const title = document.querySelector(".title");

        button_nav.addEventListener("click",()=>{
            if(list_nav.style.display === "block"){
                center.style.width = "90%";
                image.setAttribute("src","./bars.png");
                list_nav.style.display = "none";
                side_bar.style.backgroundColor = "transparent";
                side_bar.style.width = "10%";
            }
            else{
                image.setAttribute("src","./chevron-down.png");
                list_nav.style.display = "block";
                side_bar.style.backgroundColor = "#030838";
                side_bar.style.width = "300px";
                button_nav.style.backgroundColor = "#fff";
            }
            // alert('click');
        });

        // window.addEventListener("scroll",()=>{
        //     barre_nav.style.top = "-20%";
        // });

    </script>
</body>
</html>
