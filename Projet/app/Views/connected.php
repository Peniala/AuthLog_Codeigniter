<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connected</title>
    <link rel="stylesheet" href="./header.css">
    <link rel="stylesheet" href="./body.css">
    <link rel="stylesheet" href="./table.css">
    <link rel="stylesheet" href="./pagination.css">
    <link rel="stylesheet" href="./side_bar.css">
</head>
<body>
    <section class="center">
        <nav class="barre_nav">
            <form action="/Connected">
                <input type="date" name="date" id="" <?php if(isset($date)) echo "value=\"".$date."\"" ?> >
                <select name="level" id="" >
                    <option value="">All</option>
                    <option value="Li2" <?php if(isset($level) && $level === "Li2") echo "selected" ?>>L2</option>
                    <option value="Li1" <?php if(isset($level) && $level === "Li1") echo "selected" ?>>L1</option>
                    <option value="Li3" <?php if(isset($level) && $level === "Li3") echo "selected" ?>>L3</option>
                    <option value="Mi1" <?php if(isset($level) && $level === "Mi1") echo "selected" ?>>M1</option>
                    <option value="Mi2" <?php if(isset($level) && $level === "Mi2") echo "selected" ?>>M2</option>
                </select>
                <!-- <input type="checkbox" name="opened" id=""><label>Opened</label>
                <input type="checkbox" name="closed" id=""><label>Closed</label> -->
                <input type="text" placeholder="User" name="user" <?php if(isset($user)) echo "value=\"".$user."\"" ?>>
                
                <button type="submit">Search</button>
                <a href="/Auth/actualize?date=<?= $date;?>&level=<?= $level;?>&user=<?= $user;?>&page=<?= $page;?>&p=/Connected" class="actu"><button type="button">Actualize</button></a>
            </form>
        </nav>
        <h1 class="title">Connected on <?php echo $date ?></h1>
            <?php if(isset($session) && is_array($session)): ?>
                <table>
                    <tr>
                        <td>User</td>
                        <td>Level</td>
                        <td>Status</td>
                    </tr>
                    <?php foreach($session as $index => $row): ?>
                                <tr class="<?= ($index%2 != 0) ? "odd" : "even";?>">
                                    <?php 
                                        // if($i == 'date') echo "<td>".date('d-m-Y h:i:s',strtotime($col))."</td>";
                                        // else echo "<td>".$col."</td>";
                                        echo "<td>".$row['nom']." ".$row['prenoms']."</td>";
                                        echo "<td>".$row['grade'].$row['niveau']."</td>";
                                        echo ($row['type']==null) ? "<td>disconnected</td>" : "<td>connected</td>";
                                    ?>
                                </tr>
                    <?php endforeach ?>
                    
                </table>
                <?php 
                    if($cond==0){
                      echo  $pager->links(); 
                    }
                ?>
            <?php endif ?>
    </section>
    <div class="side_bar">
        <div class="button_nav">
            <img src="./bars.png" alt="Bars" id="image">
        </div>
        <div class="list">
            <a href="/Auth/export/1?date=<?= $date;?>&user=<?= $user;?>&page=<?= $page;?>" class="link link_pdf"><img class="pdf" src="file-pdf.png" alt="PDF"> Export to pdf</a>
            <a href="/Auth/export/2?date=<?= $date;?>&user=<?= $user;?>&page=<?= $page;?>" class="link link_pdf"><img class="pdf" src="file-pdf.png" alt="PDF"> Export all to pdf</a>
            <a href="/Auth" class="link">View session</a>
            <a href="/Dashboard" class="link">Dashboard</a>
            <a href='/deconnexion' class="link">Log out</a>
        </div>
    </div>
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
