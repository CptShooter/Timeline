<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Games Premiere Timeline</title>
        <script type="text/javascript" src="https://unpkg.com/vis-timeline@latest/standalone/umd/vis-timeline-graph2d.min.js"></script>
        <link href="https://unpkg.com/vis-timeline@latest/styles/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="css/style.css?ver={{hash('crc32', date('h:i:s'))}}">
    </head>
    <body>
        <h3>Games Premiere Timeline - Click on picture to open trailer</h3>
        <div id="visualization"></div>
        <script type="text/javascript">
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                // GET games from file
                let games = JSON.parse(this.responseText);

                // DOM element where the Timeline will be attached
                let container = document.getElementById('visualization');

                // Create a DataSet (allows two way data-binding)
                let items = new vis.DataSet(games);

                // Configuration for the Timeline
                let options = {
                    width: '100%',
                    margin: {
                        item: 20
                    },
                    orientation: {
                        axis: 'top',
                        item: 'top'
                    },
                    template: function (item, element, data) {
                        //console.log(item);
                        return '<div>' +
                            '<table>' +
                            '<tr>' +
                            '<td>' +
                            '<span>'+item.title+'</span>' +
                            '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>' +
                            '<a href="'+item.link+'" target="_blank">' +
                            '<img src="'+item.img+'" alt="'+item.content+'"/>' +
                            '</a>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>' +
                            '<span>'+item.start.getFullYear() + "/" + (item.start.getMonth() + 1) + "/" + item.start.getDate()+'</span>' +
                            '</td>' +
                            '</tr>' +
                            '</table>' +
                            '</div>';
                    }
                };

                // Create a Timeline
                let timeline = new vis.Timeline(container, items, options);
            }
            xhttp.open("GET", "data.php", true);
            xhttp.send();
        </script>
    </body>
</html>
