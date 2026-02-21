/* ------------------------------------------------------------------------------
 *
 *  # Dimple.js - pie with legend
 *
 *  Demo of pie chart with legend. Data stored in .tsv file format
 *
 *  Version: 1.0
 *  Latest update: August 1, 2015
 *
 * ---------------------------------------------------------------------------- */

$(function () {

    // Construct chart
    var svg = dimple.newSvg("#dimple-pie-legend", 580, 405);


    // Chart setup
    // ------------------------------

   // d3.tsv("assets/demo_data/dimple/demo_data.tsv", function (data) {
     d3.json("php/clsDistrito.php", function (error, data) {

        // Create chart
        // ------------------------------

        // Define chart
        var myChart = new dimple.chart(svg, data);

        // Set bounds
        myChart.setBounds(0, 0, "100%", "100%")

        // Set margins
        myChart.setMargins(0, 0, 100, 0);


        // Add axes
        // ------------------------------

        myChart.addMeasureAxis("p", "Cantidad");


        // Construct layout
        // ------------------------------

        // Add pie
        myChart.addSeries("Distrito", dimple.plot.pie);


        // Add legend
        // ------------------------------

        var myLegend = myChart.addLegend("100%", 0,0, "100%", "right");


        // Add styles
        // ------------------------------

        // Font size
        myLegend.fontSize = "8";

        // Font family
        myLegend.fontFamily = "Calibri";


        //
        // Draw chart
        //

        // Draw
        myChart.draw();
    });
});