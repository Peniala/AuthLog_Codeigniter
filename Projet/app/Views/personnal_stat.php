<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stat.css">    
    <title>My Calendar</title>
</head>
<body>
    <nav class="barre_nav">
        <form action="/PersonnalStat" method="GET">
            <select name="month" required>
                <option value="01" <?php if(isset($month) && $month==1) echo "selected"?> >January</option>
                <option value="02" <?php if(isset($month) && $month==2) echo "selected"?> >February</option>
                <option value="03" <?php if(isset($month) && $month==3) echo "selected"?> >March</option>
                <option value="04" <?php if(isset($month) && $month==4) echo "selected"?> >April</option>
                <option value="05" <?php if(isset($month) && $month==5) echo "selected"?> >May</option>
                <option value="06" <?php if(isset($month) && $month==6) echo "selected" ?> >June</option>
                <option value="07" <?php if(isset($month) && $month==7) echo "selected" ?> >July</option>
                <option value="08" <?php if(isset($month) && $month==8) echo "selected" ?> >August</option>
                <option value="09" <?php if(isset($month) && $month==9) echo "selected" ?> >September</option>
                <option value="10" <?php if(isset($month) && $month==10) echo "selected" ?> >October</option>
                <option value="11" <?php if(isset($month) && $month==11) echo "selected" ?> >November</option>
                <option value="12" <?php if(isset($month) && $month==12) echo "selected" ?> >December</option>
            </select>
            <input type="number" name="year" min="2023" <?php if(isset($year)) echo 'value="'.$year.'"'?>>
            <input type="hidden" name="user" placeholder="User" <?php if(isset($user)) echo 'value="'.$user.'"'; ?>>
            <button>Show</button>
        </form>
    </nav>
    
    <div class="container">
        <section class="stat">
            <h3><?php if(isset($data[0]))echo $data[0]['nom']." ".$data[0]['prenoms']; else echo "Unknown"?></h3>
            <h2><span><?php if(isset($tab)) echo count($tab)."/" ?></span><?= date("t",mktime(0,0,0,$month,1,$year)) ?></h2>
        </section>
        <table class="calendar">
            <thead>
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
                            <td <?php if($calendar["body"][$i][$j]["state"] == 1) echo 'class="valid"'; else if($calendar["body"][$i][$j]["state"] == 2) echo 'class="today"'; ?> ><?= $calendar["body"][$i][$j]["value"] ?></td>
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
        const barre_nav = document.querySelector(".barre_nav");
        const button_nav = document.querySelector(".button_nav");
        const image = document.querySelector("#image");
        const center = document.querySelector(".container");
        const list_nav = document.querySelector(".list");
        const side_bar = document.querySelector(".side_bar");
        const title = document.querySelector(".title");

        button_nav.addEventListener("click",()=>{
            if(list_nav.style.display === "block"){
                center.style.width = "90%";
                barre_nav.style.width = "90%";
                barre_nav.style.height = "15%";
                barre_nav.style.textAlign = "left";
                image.setAttribute("src","./bars.png");
                list_nav.style.display = "none";
                side_bar.style.backgroundColor = "#ececec";
                side_bar.style.width = "10%";
                title.style.marginTop = "8%";
            }
            else{
                center.style.width = "80%";
                barre_nav.style.width = "80%";
                barre_nav.style.height = "18%";
                barre_nav.style.textAlign = "center";
                image.setAttribute("src","./chevron-down.png");
                list_nav.style.display = "block";
                side_bar.style.backgroundColor = "#030838";
                side_bar.style.width = "20%";
                button_nav.style.backgroundColor = "#fff";
                title.style.marginTop = "12%";
            }
            // alert('click');
        });
    </script>
</body>
</html>