<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        /* *{
            border: solid;
        } */
        .charts{
            margin-top: 15%; 
            display: grid;
            grid-template-columns: repeat(2,0.5fr);
            align-content: center;
        }
        .license, .master{
            display: grid;
            grid-template-columns: repeat(2,1fr);
        }
        .pie{
            width: 80%;
            height: auto;
            text-align: center;
        }
        .bars{
            width: 90%;
        }
        h4{
            color: #888;
            text-align: center;
            margin: 1vw 1vh;
        }
    </style>
</head>
<body>
    <nav class="barre_nav">
            <form action="/Dashboard">
                <input type="date" name="date" id="" <?php if(isset($date)) echo "value=\"".$date."\"" ?> >
                <!-- <select name="level" id="" >
                    <option value="">All</option>
                    <option value="l1" <?php if(isset($type) && $type == "opened") echo "selected" ?>>L1</option>
                    <option value="l2" <?php if(isset($type) && $type == "closed") echo "selected" ?>>L2</option>
                    <option value="l3" <?php if(isset($type) && $type == "opened") echo "selected" ?>>L3</option>
                    <option value="m1" <?php if(isset($type) && $type == "closed") echo "selected" ?>>M1</option>
                    <option value="m2" <?php if(isset($type) && $type == "closed") echo "selected" ?>>M2</option>
                </select>     -->
            <button type="submit">Search</button>
            <a href="/Auth/actualize?date=<?= $date;?>&p=/Dashboard" class="actu"><button type="button">Actualize</button></a>
        </form>
    </nav>
    <section class="charts center">
        <div class="pie">
            <canvas id="global"></canvas>
        </div>
        <div class="levels">
            <div class="license">
                <div class="bars">
                    <h4>License 1</h4>
                    <canvas id="l1Chart"></canvas>
                </div>
                <div class="bars">
                    <h4>License 2</h4>
                    <canvas id="l2Chart"></canvas>
                </div>
                <div class="bars">
                    <h4>License 3</h4>
                    <canvas id="l3Chart"></canvas>
                </div>
            </div>
            <div class="master">
                <div class="bars">
                    <h4>Master 1</h4>
                    <canvas id="m1Chart"></canvas>
                </div>
                <div class="bars">
                    <h4>Master 2</h4>
                    <canvas id="m2Chart"></canvas>
                </div>
            </div>
        </div>
    </section>
    <div class="side_bar">
        <div class="button_nav">
            <img src="./bars.png" alt="Bars" id="image">
        </div>
        <div class="list">
            <a href="/Auth/export/1?date=<?= $date;?>" class="link link_pdf"><img class="pdf" src="file-pdf.png" alt="PDF"> Export to PDF</a>
            <a href="/Auth" class="link">View session</a>
            <a href="/Dashboard" class="actived link">Dashboard</a>
        </div>
    </div>
    <script src="../chart.js-4.4.2/package/dist/chart.umd.js"></script>
    <script>
        const globalChart = document.getElementById('global');
        const l1Chart = document.getElementById('l1Chart');
        const l2Chart = document.getElementById('l2Chart');
        const l3Chart = document.getElementById('l3Chart');
        const m1Chart = document.getElementById('m1Chart');
        const m2Chart = document.getElementById('m2Chart');

        new Chart(globalChart, {
            type: 'pie',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    label : ['Connected','Not connected'],
                    backgroundColor:['#471696','#aaa1d8'],
                    data: [<?= count($l1+$l2+$l3+$m1+$m2).",".count($l1_c+$l2_c+$l3_c+$m1_c+$m2_c);?>]
                }]
            }
        });
        new Chart(l1Chart, {
            type: 'bar',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    label : ['Connected','Not connected'],
                    backgroundColor:['#00977e','#fc844d'],
                    data: [<?= count($l1).",".count($l1_c);?>]
                }]
            }
        });
        new Chart(l2Chart, {
            type: 'bar',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    label : ['Connected','Not connected'],
                    backgroundColor:['#109754','#f7693e'],
                    data: [<?= count($l2).",".count($l2_c);?>]
                }]
            }
        });
        new Chart(l3Chart, {
            type: 'bar',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    label : ['Connected','Not connected'],
                    backgroundColor:['#36506d','#e22626'],
                    data: [<?= count($l3).",".count($l3_c);?>]
                }]
            }
        });
        new Chart(m1Chart, {
            type: 'bar',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    label : ['Connected','Not connected'],
                    backgroundColor:['#0d1094','#df0303'],
                    data: [<?= count($m1).",".count($m1_c);?>]
                }]
            }
        });
        new Chart(m2Chart, {
            type: 'bar',
            data: {
                labels: ['Connected','Not connected'],
                datasets: [{
                    label : ['Connected','Not connected'],
                    backgroundColor:['#1e21da','#ff0000'],
                    data: [<?= count($m2).",".count($m2_c);?>]
                }]
            }
        });

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
                barre_nav.style.width = "90%";
                barre_nav.style.height = "15%";
                barre_nav.style.textAlign = "left";
                image.setAttribute("src","./bars.png");
                list_nav.style.display = "none";
                side_bar.style.backgroundColor = "#fff";
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
                title.style.marginTop = "11%";
            }
            // alert('click');
        });

        window.addEventListener("onscroll",()=>{

        });

    </script>
</body>
</html>