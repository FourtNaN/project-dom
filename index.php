<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Muplace</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>

<body class="p-0">
    <section class="row">

        <?php include("aside.php"); ?>

        <main class="col-9 col-xl-10  bg-white border border-5">
            <div class="mt-3 mb-3">
                <h1 class="prompt-bold text-custom-1 text-center">ห้องว่างห้องเต็ม</h1>
            </div>
            <?php
            require 'dbconnection.php';
            $sql = "SELECT * FROM rooms ORDER BY floor, room_number";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                for ($floor = 1; $floor <= 8; $floor++) {
                    echo "<h2 class='m-3' >ชั้นที่ " . $floor . "</h2><hr>";

                    for ($room = 1; $room <= 23; $room++) {
                        $room_number = sprintf("%d%02d", $floor, $room);


                        $status = 'available';
                        while ($row = $result->fetch_assoc()) {
                            if ($row['room_number'] == $room_number) {
                                $status = $row['status'];
                                break;
                            }
                        }


                        $status_class = '';
                        if ($status == 'available') {
                            $status_class = 'green';
                        } elseif ($status == 'booked') {
                            $status_class = 'yellow';
                        } elseif ($status == 'unavailable') {
                            $status_class = 'red';
                        }


                        echo '<a href="RoomInfo.php?room_number=' . $room_number . '" class="room-button ' . $status_class . '">';
                        echo $room_number;
                        echo '</a>';
                    }
                }
            } else {
                echo "No rooms found in database.";
            }
            include 'footer.php'
            ?>
        </main>
    </section>