<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <section class="center">
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
                <a href="Auth/actualize" class="actu"><button type="button">Actualize</button></a>
            </form>
        </nav>
        <h1>Auth.log file</h1>
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
                                        if($i == 'date') echo "<td>".date('d-m-Y h:i:s',strtotime($col))."</td>";
                                        else echo "<td>".$col."</td>";
                                    endforeach ?>
                                </tr>
                    <?php endforeach ?>
                    
                </table>
                <?= $pager->links() ?>
            <?php endif ?>
    </section>
    <div class="side_bar">
        <div class="button_nav">
            <img src="./bars.svg" alt="Bars" id="image">
        </div>
        <div class="list">
            <a href=""><button>View session</button></a>
            <a href=""><button>Dashboard</button></a>
        </div>
    </div>
    <script >
        const button_nav = document.querySelector(".button_nav");
        const image = document.querySelector("#image");
        const center = document.querySelector(".center");
        const list_nav = document.querySelector(".list");
        const side_bar = document.querySelector(".side_bar");

        button_nav.addEventListener("click",()=>{
            if(list_nav.style.display === "none"){
                center.style.width = "80%";
                image.setAttribute("src","./chevron-down.svg");
                list_nav.style.display = "block";
                side_bar.style.backgroundColor = "#030838";
                side_bar.style.width = "20%";
            }
            else{
                center.style.width = "95%";
                image.setAttribute("src","./bars.svg");
                list_nav.style.display = "none";
                side_bar.style.backgroundColor = "#fff";
                side_bar.style.width = "5%";
            }
            // alert('click');
        });
    </script>
</body>
</html>
