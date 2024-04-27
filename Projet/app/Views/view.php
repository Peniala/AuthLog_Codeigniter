<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
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
        <input type="text" placeholder="Process" name="process" <?php if(isset($process)) echo "value=\"".$process."\"" ?>>
        <input type="text" placeholder="User" name="user" <?php if(isset($user)) echo "value=\"".$user."\"" ?>>
        <button type="submit">Search</button>
        <a href="Auth/actualize" class="actu"><button type="button">Actualize</button></a>
    </form>
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
                                <?php foreach($row as $col): ?>
                                    <td><?php echo $col ?></td>
                                <?php endforeach ?>
                            </tr>
                <?php endforeach ?>
                
            </table>
            <?= $pager->links() ?>
        <?php endif ?>
    
</body>
</html>
