
$(function() {    

    marcadores_dash();

    var switches = Array.prototype.slice.call(document.querySelectorAll('.switch'));
    switches.forEach(function(html) {
        var switchery = new Switchery(html, {color: '#4CAF50'});
    });
    
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                var f=new Date();
                fecha=(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
                fecha2=(f.getMonth()+1 + "/" +f.getDate() + "/" + f.getFullYear());
                fecha1=(f.getMonth() + "/01/" + f.getFullYear());
                console.log(fecha2);
                console.log(fecha1);

    $('.daterange-ranges').daterangepicker(
        {
            
           // console.log( moment());
            startDate: moment().subtract('days', 29),
            endDate: moment(),
            minDate: fecha1,
            maxDate: fecha2,
            dateLimit: { days: 60 },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            opens: 'left',
            applyClass: 'btn-small bg-slate-600 btn-block',
            cancelClass: 'btn-small btn-default btn-block',
            //format: 'DD/MM/YYYY'
            locale: {
                    format: 'YYYY-MM-DD',
                    separator: " / ",
                    applyLabel: "Aceptar",
                    cancelLabel: "Cancel",
                daysOfWeek: [
                    "Do",
                    "Lu",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sab"
                ],
                monthNames: [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                firstDay: 1
            }
        },
        function(start, end) {
            $('.daterange-ranges span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        }
    );

    $('.daterange-ranges span').html(moment().subtract('days', 29).format('YYYY-MM-DD') + ' - ' + moment().format('YYYY-MM-DD'));


    trafficSources('#traffic-sources', 350); // initialize chart

    // Chart setup
    function trafficSources(element, height) {

        // Define main variables
        var d3Container = d3.select(element),
            margin = {top: 5, right: 50, bottom: 40, left: 50},
            width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
            height = height - margin.top - margin.bottom,
            tooltipOffset = 30;

        // Tooltip
        var tooltip = d3Container
            .append("div")
            .attr("class", "d3-tip e")
            .style("display", "none")

        // Format date
        var format = d3.time.format("%m/%d/%y %H:%M");
        var formatDate = d3.time.format("%H:%M");

        // Colors
        var colorrange = ['#03A9F4', '#29B6F6', '#4FC3F7', '#81D4FA', '#B3E5FC'];

        // Horizontal
        var x = d3.time.scale().range([0, width]);

        // Vertical
        var y = d3.scale.linear().range([height, 0]);

        // Colors
        var z = d3.scale.ordinal().range(colorrange);

        // Horizontal
        var xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom")
            .ticks(d3.time.hours, 4)
            .innerTickSize(4)
            .tickPadding(8)
            .tickFormat(d3.time.format("%H:%M")); // Display hours and minutes in 24h format

        // Left vertical
        var yAxis = d3.svg.axis()
            .scale(y)
            .ticks(6)
            .innerTickSize(4)
            .outerTickSize(0)
            .tickPadding(8)
            .tickFormat(function (d) { return (d/1000) + "k"; });

        // Right vertical
        var yAxis2 = yAxis;

        // Dash lines
        var gridAxis = d3.svg.axis()
            .scale(y)
            .orient("left")
            .ticks(6)
            .tickPadding(8)
            .tickFormat("")
            .tickSize(-width, 0, 0);

        // Container
        var container = d3Container.append("svg")

        // SVG element
        var svg = container
            .attr('width', width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

        // Stack
        var stack = d3.layout.stack()
            .offset("silhouette")
            .values(function(d) { return d.values; })
            .x(function(d) { return d.date; })
            .y(function(d) { return d.value; });

        // Nest
        var nest = d3.nest()
            .key(function(d) { return d.key; });

        // Area
        var area = d3.svg.area()
            .interpolate("cardinal")
            .x(function(d) { return x(d.date); })
            .y0(function(d) { return y(d.y0); })
            .y1(function(d) { return y(d.y0 + d.y); });

        //d3.csv("assets/demo_data/dashboard/traffic_sources.csv", function (error, data) {
        d3.json("php/clsTrafico.php", function (error, data) {
            // Pull out values
            data.forEach(function (d) {
                d.date = format.parse(d.date);
                d.value = +d.value;
            });

            // Stack and nest layers
            var layers = stack(nest.entries(data));

            // Horizontal
            x.domain(d3.extent(data, function(d, i) { return d.date; }));

            // Vertical
            y.domain([0, d3.max(data, function(d) { return d.y0 + d.y; })]);

            // Horizontal grid. Must be before the group
            svg.append("g")
                .attr("class", "d3-grid-dashed")
                .call(gridAxis);

            // Create group
            var group = svg.append('g')
                .attr('class', 'streamgraph-layers-group');

            // And append paths to this group
            var layer = group.selectAll(".streamgraph-layer")
                .data(layers)
                .enter()
                    .append("path")
                    .attr("class", "streamgraph-layer")
                    .attr("d", function(d) { return area(d.values); })                    
                    .style('stroke', '#fff')
                    .style('stroke-width', 0.5)
                    .style("fill", function(d, i) { return z(i); });

            // Add transition
            var layerTransition = layer
                .style('opacity', 0)
                .transition()
                    .duration(750)
                    .delay(function(d, i) { return i * 50; })
                    .style('opacity', 1)

            svg.append("g")
                .attr("class", "d3-axis d3-axis-left d3-axis-solid")
                .call(yAxis.orient("left"));

            // Hide first tick
            d3.select(svg.selectAll('.d3-axis-left .tick text')[0][0])
                .style("visibility", "hidden");


            svg.append("g")
                .attr("class", "d3-axis d3-axis-right d3-axis-solid")
                .attr("transform", "translate(" + width + ", 0)")
                .call(yAxis2.orient("right"));

            // Hide first tick
            d3.select(svg.selectAll('.d3-axis-right .tick text')[0][0])
                .style("visibility", "hidden");


            var xaxisg = svg.append("g")
                .attr("class", "d3-axis d3-axis-horizontal d3-axis-solid")
                .attr("transform", "translate(0," + height + ")")
                .call(xAxis);

            // Add extra subticks for hidden hours
            xaxisg.selectAll(".d3-axis-subticks")
                .data(x.ticks(d3.time.hours), function(d) { return d; })
                .enter()
                .append("line")
                .attr("class", "d3-axis-subticks")
                .attr("y1", 0)
                .attr("y2", 4)
                .attr("x1", x)
                .attr("x2", x);

            // Append group to the group of paths to prevent appearance outside chart area
            var hoverLineGroup = group.append("g")
                .attr("class", "hover-line");

            // Add line
            var hoverLine = hoverLineGroup
                .append("line")
                .attr("y1", 0)
                .attr("y2", height)
                .style('fill', 'none')
                .style('stroke', '#fff')
                .style('stroke-width', 1)
                .style('pointer-events', 'none')
                .style('shape-rendering', 'crispEdges')
                .style("opacity", 0);

            // Add pointer
            var hoverPointer = hoverLineGroup
                .append("rect")
                .attr("x", 2)
                .attr("y", 2)
                .attr("width", 6)
                .attr("height", 6)
                .style('fill', '#03A9F4')
                .style('stroke', '#fff')
                .style('stroke-width', 1)
                .style('shape-rendering', 'crispEdges')
                .style('pointer-events', 'none')
                .style("opacity", 0);



            // Append events to the layers group
            // ------------------------------

            layerTransition.each("end", function() {
                layer
                    .on("mouseover", function (d, i) {
                        svg.selectAll(".streamgraph-layer")
                            .transition()
                            .duration(250)
                            .style("opacity", function (d, j) {
                                return j != i ? 0.75 : 1; // Mute all except hovered
                            });
                    })

                    .on("mousemove", function (d, i) {
                        mouse = d3.mouse(this);
                        mousex = mouse[0];
                        mousey = mouse[1];
                        datearray = [];
                        var invertedx = x.invert(mousex);
                        invertedx = invertedx.getHours();
                        var selected = (d.values);
                       // console.log(selected);
                        for (var k = 0; k < selected.length; k++) {
                           
                            datearray[k] = selected[k].date
                            datearray[k] = datearray[k].getHours();
                            
                           // console.log(selected[k].date);
                        }
                        mousedate = datearray.indexOf(invertedx);
                        pro = d.values[mousedate].value;
                        //console.log(d.values[mousedate]);

                        // Display mouse pointer
                        hoverPointer
                            .attr("x", mousex - 3)
                            .attr("y", mousey - 6)
                            .style("opacity", 1);

                        hoverLine
                            .attr("x1", mousex)
                            .attr("x2", mousex)
                            .style("opacity", 1);

                        //
                        // Tooltip
                        //

                        // Tooltip data
                        tooltip.html(
                            "<ul class='list-unstyled mb-5'>" +
                                "<li>" + "<div class='text-size-base mt-5 mb-5'><i class='icon-circle-left2 position-left'></i>" + d.key + "</div>" + "</li>" +
                                "<li>" + "Logeo: &nbsp;" + "<span class='text-semibold pull-right'>" + pro + "</span>" + "</li>" +
                                "<li>" + "Hora: &nbsp; " + "<span class='text-semibold pull-right'>" + formatDate(d.values[mousedate].date) + "</span>" + "</li>" + 
                            "</ul>"
                        )
                        .style("display", "block");

                        // Tooltip arrow
                        tooltip.append('div').attr('class', 'd3-tip-arrow');
                    })

                    .on("mouseout", function (d, i) {

                        // Revert full opacity to all paths
                        svg.selectAll(".streamgraph-layer")
                            .transition()
                            .duration(250)
                            .style("opacity", 1);

                        // Hide cursor pointer
                        hoverPointer.style("opacity", 0);

                        // Hide tooltip
                        tooltip.style("display", "none");

                        hoverLine.style("opacity", 0);
                    });
                });



            // Append events to the chart container
            // ------------------------------

            d3Container
                .on("mousemove", function (d, i) {
                    mouse = d3.mouse(this);
                    mousex = mouse[0];
                    mousey = mouse[1];

                    // Display hover line
                        //.style("opacity", 1);


                    // Move tooltip vertically
                    tooltip.style("top", (mousey - ($('.d3-tip').outerHeight() / 2)) - 2 + "px") // Half tooltip height - half arrow width

                    // Move tooltip horizontally
                    if(mousex >= ($(element).outerWidth() - $('.d3-tip').outerWidth() - margin.right - (tooltipOffset * 2))) {
                        tooltip
                            .style("left", (mousex - $('.d3-tip').outerWidth() - tooltipOffset) + "px") // Change tooltip direction from right to left to keep it inside graph area
                            .attr("class", "d3-tip w");
                    }
                    else {
                        tooltip
                            .style("left", (mousex + tooltipOffset) + "px" )
                            .attr("class", "d3-tip e");
                    }
                });
        });


        // Call function on window resize
        $(window).on('resize', resizeStream);

        // Call function on sidebar width change
        $(document).on('click', '.sidebar-control', resizeStream);

        function resizeStream() {

            // Define width
            width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;

            // Main svg width
            container.attr("width", width + margin.left + margin.right);

            // Width of appended group
            svg.attr("width", width + margin.left + margin.right);

            // Horizontal range
            x.range([0, width]);

            // Horizontal axis
            svg.selectAll('.d3-axis-horizontal').call(xAxis);

            // Horizontal axis subticks
            svg.selectAll('.d3-axis-subticks').attr("x1", x).attr("x2", x);

            // Grid lines width
            svg.selectAll(".d3-grid-dashed").call(gridAxis.tickSize(-width, 0, 0))

            // Right vertical axis
            svg.selectAll(".d3-axis-right").attr("transform", "translate(" + width + ", 0)");

            // Area paths
            svg.selectAll('.streamgraph-layer').attr("d", function(d) { return area(d.values); });
        }
    }

    salesHeatmap(); 
    
    function salesHeatmap() {

        d3.csv("assets/demo_data/dashboard/app_sales_heatmap.csv", function(error, data) {

            // Nest data
            var nested_data = d3.nest().key(function(d) { return d.app; }),
                nest = nested_data.entries(data);

            // Format date
            var format = d3.time.format("%Y/%m/%d %H:%M"),
                formatTime = d3.time.format("%H:%M");

            // Pull out values
            data.forEach(function(d, i) { 
                d.date = format.parse(d.date),
                d.value = +d.value
            });

        });
    }
    
    sparkline("#new-visitors", "line", 30, 35, "basis", 750, 2000, "#26A69A");
    sparkline("#new-sessions", "line", 30, 35, "basis", 750, 2000, "#FF7043");
    sparkline("#total-online", "line", 30, 35, "basis", 750, 2000, "#5C6BC0");
    sparkline("#server-load", "area", 30, 50, "basis", 750, 2000, "rgba(255,255,255,0.5)");

    // Chart setup
    function sparkline(element, chartType, qty, height, interpolation, duration, interval, color) {

        // Define main variables
        var d3Container = d3.select(element),
            margin = {top: 0, right: 0, bottom: 0, left: 0},
            width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
            height = height - margin.top - margin.bottom;


        // Generate random data (for demo only)
        var data = [];
        for (var i=0; i < qty; i++) {
            data.push(Math.floor(Math.random() * qty) + 5)
        }

        // Horizontal
        var x = d3.scale.linear().range([0, width]);

        // Vertical
        var y = d3.scale.linear().range([height - 5, 5]);

        // Horizontal
        x.domain([1, qty - 3])

        // Vertical
        y.domain([0, qty])
            
        var line = d3.svg.line()
            .interpolate(interpolation)
            .x(function(d, i) { return x(i); })
            .y(function(d, i) { return y(d); });

        // Area
        var area = d3.svg.area()
            .interpolate(interpolation)
            .x(function(d,i) { 
                return x(i); 
            })
            .y0(height)
            .y1(function(d) { 
                return y(d); 
            });

        // Container
        var container = d3Container.append('svg');

        // SVG element
        var svg = container
            .attr('width', width + margin.left + margin.right)
            .attr('height', height + margin.top + margin.bottom)
            .append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

        // Add clip path
        var clip = svg.append("defs")
            .append("clipPath")
            .attr('id', function(d, i) { return "load-clip-" + element.substring(1) })

        // Add clip shape
        var clips = clip.append("rect")
            .attr('class', 'load-clip')
            .attr("width", 0)
            .attr("height", height);

        // Animate mask
        clips
            .transition()
                .duration(1000)
                .ease('linear')
                .attr("width", width);


        // Main path
        var path = svg.append("g")
            .attr("clip-path", function(d, i) { return "url(#load-clip-" + element.substring(1) + ")"})
            .append("path")
                .datum(data)
                .attr("transform", "translate(" + x(0) + ",0)");

        // Add path based on chart type
        if(chartType == "area") {
            path.attr("d", area).attr('class', 'd3-area').style("fill", color); // area
        }
        else {
            path.attr("d", line).attr("class", "d3-line d3-line-medium").style('stroke', color); // line
        }

        // Animate path
        path
            .style('opacity', 0)
            .transition()
                .duration(750)
                .style('opacity', 1);


        setInterval(function() {
            data.push(Math.floor(Math.random() * qty) + 5);
            data.shift();

            update();

        }, interval);


        function update() {
            path
                .attr("transform", null)
                .transition()
                    .duration(duration)
                    .ease("linear")
                    .attr("transform", "translate(" + x(0) + ",0)");

            // Update path type
            if(chartType == "area") {
                path.attr("d", area).attr('class', 'd3-area').style("fill", color)
            }
            else {
                path.attr("d", line).attr("class", "d3-line d3-line-medium").style('stroke', color);
            }
        }

        $(window).on('resize', resizeSparklines);

        // Call function on sidebar width change
        $(document).on('click', '.sidebar-control', resizeSparklines);
        
        function resizeSparklines() {

            // Layout variables
            width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;

            container.attr("width", width + margin.left + margin.right);

            // Width of appended group
            svg.attr("width", width + margin.left + margin.right);

            // Horizontal range
            x.range([0, width]);

            clips.attr("width", width);

            // Line
            svg.select(".d3-line").attr("d", line);

            // Area
            svg.select(".d3-area").attr("d", area);
        }
    }

    //dailyRevenue('#today-revenue', '50'); // initialize chart

    // Chart setup
    function dailyRevenue(element, alto) {
         $.ajax({
            dataType: 'json',
            url: 'ajax/ajax_dashboard.php',
            success:  function (response) {
                var dataset1=response.arr_datos0;
                //element = dataset1[0][2];
                //height = dataset1[0][3];
                var height = alto;
                var dataset= new Array();
                for (var i = 0; i < dataset1.length; i++) {
                    dataset.push({'date':dataset1[i][0], 'alpha': dataset1[i][1]});
                }
                
                var d3Container = d3.select(element),
                    margin = {top: 0, right: 0, bottom: 0, left: 0},
                    width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
                    height = height - margin.top - margin.bottom,
                    padding = 20;

                // Format date
                var parseDate = d3.time.format("%d/%m/%y").parse,
                    formatDate = d3.time.format("%a, %e %B");

                var tooltip = d3.tip()
                    .attr('class', 'd3-tip')
                    .html(function (d) {
                        return "<ul class='list-unstyled mb-5'>" +
                            "<li>" + "<div class='text-size-base mt-5 mb-5'><i class='icon-check2 position-left'></i>" + formatDate(d.date).replace("December", "Diciembre").replace("November", "Noviembre").replace("October", "Octubre").replace("September", "Septiembre").replace("August", "Agosto").replace("February", "Febrero").replace("January", "Enero").replace("July", "Julio").replace("June", "Junio").replace("May", "Mayo").replace("April", "Abril").replace("March", "Marzo").replace("March", "Marzo").replace("Thu", "Jueves").replace("Sat", "Sábado").replace("Sun", "Domingo").replace("Mon", "Lunes").replace("Wed", "Miércoles").replace("Fri", "Viernes").replace("Tue", "Martes") + "</div>" + "</li>" +
                            "<li>" + "Total: &nbsp;" + "<span class='text-semibold pull-right'>" + d.alpha + "</span>" + "</li>" +
                        "</ul>";
                    });

                // Add svg element
                var container = d3Container.append('svg');
                
                // Add SVG group
                var svg = container
                        .attr('width', width + margin.left + margin.right)
                        .attr('height', height + margin.top + margin.bottom)
                        .append("g")
                            .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
                            .call(tooltip);

                // Load data
                // ------------------------------
                dataset.forEach(function (d) {
                    d.date = parseDate(d.date);
                    d.alpha =+ d.alpha;
                });

                // Construct scales
                // ------------------------------
                // Horizontal
                var x = d3.time.scale()
                    .range([padding, width - padding]);

                // Vertical
                var y = d3.scale.linear()
                    .range([height, 5]);

                x.domain(d3.extent(dataset, function (d) {
                    return d.date;
                }));

                // Vertical
                y.domain([0, d3.max(dataset, function (d) {
                    return Math.max(d.alpha);
                })]);

                // Construct chart layout
                // ------------------------------
                // Line
                var line = d3.svg.line()
                    .x(function(d) {
                        return x(d.date);
                    })
                    .y(function(d) {
                        return y(d.alpha)
                    });

                // Add clip path
                var clip = svg.append("defs")
                    .append("clipPath")
                    .attr("id", "clip-line-small");

                // Add clip shape
                var clipRect = clip.append("rect")
                    .attr('class', 'clip')
                    .attr("width", 0)
                    .attr("height", height);

                // Animate mask
                clipRect
                      .transition()
                          .duration(1000)
                          .ease('linear')
                          .attr("width", width);

                // Line
                // ------------------------------
                // Path
                var path = svg.append('path')
                    .attr({
                        'd': line(dataset),
                        "clip-path": "url(#clip-line-small)",
                        'class': 'd3-line d3-line-medium'
                    })
                    .style('stroke', '#fff');

                // Animate path
                svg.select('.line-tickets')
                    .transition()
                        .duration(1000)
                        .ease('linear');

                // Add vertical guide lines
                // ------------------------------
                // Bind data
                var guide = svg.append('g')
                    .selectAll('.d3-line-guides-group')
                    .data(dataset);

                // Append lines
                guide
                    .enter()
                    .append('line')
                        .attr('class', 'd3-line-guides')
                        .attr('x1', function (d, i) {
                            return x(d.date);
                        })
                        .attr('y1', function (d, i) {
                            return height;
                        })
                        .attr('x2', function (d, i) {
                            return x(d.date);
                        })
                        .attr('y2', function (d, i) {
                            return height;
                        })
                        .style('stroke', 'rgba(255,255,255,0.3)')
                        .style('stroke-dasharray', '4,2')
                        .style('shape-rendering', 'crispEdges');

                // Animate guide lines
                guide
                    .transition()
                        .duration(1000)
                        .delay(function(d, i) { return i * 150; })
                        .attr('y2', function (d, i) {
                            return y(d.alpha);
                        });

                // Alpha app points
                // ------------------------------
                // Add points
                var points = svg.insert('g')
                    .selectAll('.d3-line-circle')
                    .data(dataset)
                    .enter()
                    .append('circle')
                        .attr('class', 'd3-line-circle d3-line-circle-medium')
                        .attr("cx", line.x())
                        .attr("cy", line.y())
                        .attr("r", 3)
                        .style('stroke', '#fff')
                        .style('fill', '#29B6F6');

                // Animate points on page load
                points
                    .style('opacity', 0)
                    .transition()
                        .duration(250)
                        .ease('linear')
                        .delay(1000)
                        .style('opacity', 1);

                // Add user interaction
                points
                    .on("mouseover", function (d) {
                        tooltip.offset([-10, 0]).show(d);

                        // Animate circle radius
                        d3.select(this).transition().duration(250).attr('r', 4);
                    })

                // Hide tooltip
                .on("mouseout", function (d) {
                    tooltip.hide(d);

                    // Animate circle radius
                    d3.select(this).transition().duration(250).attr('r', 3);
                });

                // Change tooltip direction of first point
                d3.select(points[0][0])
                    .on("mouseover", function (d) {
                        tooltip.offset([0, 10]).direction('e').show(d);

                        // Animate circle radius
                        d3.select(this).transition().duration(250).attr('r', 4);
                    })
                    .on("mouseout", function (d) {
                        tooltip.direction('n').hide(d);

                        // Animate circle radius
                        d3.select(this).transition().duration(250).attr('r', 3);
                    });

                // Change tooltip direction of last point
                d3.select(points[0][points.size() - 1])
                    .on("mouseover", function (d) {
                        tooltip.offset([0, -10]).direction('w').show(d);

                        // Animate circle radius
                        d3.select(this).transition().duration(250).attr('r', 4);
                    })
                    .on("mouseout", function (d) {
                        tooltip.direction('n').hide(d);

                        // Animate circle radius
                        d3.select(this).transition().duration(250).attr('r', 3);
                    })

                $(window).on('resize', revenueResize(width,container,d3Container,margin,padding,svg,x,clipRect,line,dataset));

                // Call function on sidebar width change
                $(document).on('click', '.sidebar-control', revenueResize(width,container,d3Container,margin,padding,svg,x,clipRect,line,dataset));
                /*END AJAX*/
           }
        });
    }

    function revenueResize(width,container,d3Container,margin,padding,svg,x,clipRect,line,dataset) {
        // Layout variables
        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;
        // Layout
        // -------------------------
        // Main svg width
        container.attr("width", width + margin.left + margin.right);
        // Width of appended group
        svg.attr("width", width + margin.left + margin.right);
        // Horizontal range
        x.range([padding, width - padding]);
        // Chart elements
        // -------------------------
        // Mask
        clipRect.attr("width", width);
        // Line path
        svg.selectAll('.d3-line').attr("d", line(dataset));
        // Circles
        svg.selectAll('.d3-line-circle').attr("cx", line.x());
        // Guide lines
        svg.selectAll('.d3-line-guides')
            .attr('x1', function (d, i) {
                return x(d.date);
            })
            .attr('x2', function (d, i) {
                return x(d.date);
            });
    }

    progressMeter("#today-progress", 20, 20, '#7986CB');
    progressMeter("#yesterday-progress", 20, 20, '#7986CB');

    // Chart setup
    function progressMeter(element, width, height, color) {

        var d3Container = d3.select(element),
            border = 2,
            radius = Math.min(width / 2, height / 2) - border,
            twoPi = 2 * Math.PI,
            progress = $(element).data('progress'),
            total = 100;

        var arc = d3.svg.arc()
            .startAngle(0)
            .innerRadius(0)
            .outerRadius(radius)
            .endAngle(function(d) {
              return (d.value / d.size) * 2 * Math.PI; 
            })

        var container = d3Container.append("svg");

        // Add SVG group
        var svg = container
            .attr("width", width)
            .attr("height", height)
            .append("g")
                .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

        // Progress group
        var meter = svg.append("g")
            .attr("class", "progress-meter");

        // Background
        meter.append("path")
            .attr("d", arc.endAngle(twoPi))
            .style('fill', '#fff')
            .style('stroke', color)
            .style('stroke-width', 1.5);

        // Foreground
        var foreground = meter.append("path")
            .style('fill', color);

        // Animate foreground path
        foreground
            .transition()
                .ease("cubic-out")
                .duration(2500)
                .attrTween("d", arcTween);


        // Tween arcs
        function arcTween() {
            var i = d3.interpolate(0, progress);
            return function(t) {
                var currentProgress = progress / (100/t);
                var endAngle = arc.endAngle(twoPi * (currentProgress));
                return arc(i(endAngle));
            };
        }
    }

    function ticketStatusDonut(element, size) {
        // Add data set
        var data = [
            {
                "status": "Pending proyectos",
                "icon": "<i class='status-mark border-blue-300 position-left'></i>",
                "value": 295,
                "color": "#29B6F6"
            }, {
                "status": "Resolved proyectos",
                "icon": "<i class='status-mark border-success-300 position-left'></i>",
                "value": 189,
                "color": "#66BB6A"
            }, {
                "status": "Closed proyectos",
                "icon": "<i class='status-mark border-danger-300 position-left'></i>",
                "value": 277,
                "color": "#EF5350"
            }
        ];

        // Main variables
        var d3Container = d3.select(element),
            distance = 2, // reserve 2px space for mouseover arc moving
            radius = (size/2) - distance,
            sum = d3.sum(data, function(d) { return d.value; })

        var tip = d3.tip()
            .attr('class', 'd3-tip')
            .offset([-10, 0])
            .direction('e')
            .html(function (d) {
                return "<ul class='list-unstyled mb-5'>" +
                    "<li>" + "<div class='text-size-base mb-5 mt-5'>" + d.data.icon + d.data.status + "</div>" + "</li>" +
                    "<li>" + "Total: &nbsp;" + "<span class='text-semibold pull-right'>" + d.value + "</span>" + "</li>" +
                    "<li>" + "Share: &nbsp;" + "<span class='text-semibold pull-right'>" + (100 / (sum / d.value)).toFixed(2) + "%" + "</span>" + "</li>" +
                "</ul>";
            })

        // Add svg element
        var container = d3Container.append("svg").call(tip);
        
        // Add SVG group
        var svg = container
            .attr("width", size)
            .attr("height", size)
            .append("g")
                .attr("transform", "translate(" + (size / 2) + "," + (size / 2) + ")");  

        // Pie
        var pie = d3.layout.pie()
            .sort(null)
            .startAngle(Math.PI)
            .endAngle(3 * Math.PI)
            .value(function (d) { 
                return d.value;
            }); 

        // Arc
        var arc = d3.svg.arc()
            .outerRadius(radius)
            .innerRadius(radius / 2);

        // Group chart elements
        var arcGroup = svg.selectAll(".d3-arc")
            .data(pie(data))
            .enter()
            .append("g") 
                .attr("class", "d3-arc")
                .style('stroke', '#fff')
                .style('cursor', 'pointer');
        
        // Append path
        var arcPath = arcGroup
            .append("path")
            .style("fill", function (d) { return d.data.color; });

        // Add tooltip
        arcPath
            .on('mouseover', function (d, i) {

                // Transition on mouseover
                d3.select(this)
                .transition()
                    .duration(500)
                    .ease('elastic')
                    .attr('transform', function (d) {
                        d.midAngle = ((d.endAngle - d.startAngle) / 2) + d.startAngle;
                        var x = Math.sin(d.midAngle) * distance;
                        var y = -Math.cos(d.midAngle) * distance;
                        return 'translate(' + x + ',' + y + ')';
                    });
            })

            .on("mousemove", function (d) {
                
                // Show tooltip on mousemove
                tip.show(d)
                    .style("top", (d3.event.pageY - 40) + "px")
                    .style("left", (d3.event.pageX + 30) + "px");
            })

            .on('mouseout', function (d, i) {

                // Mouseout transition
                d3.select(this)
                .transition()
                    .duration(500)
                    .ease('bounce')
                    .attr('transform', 'translate(0,0)');

                // Hide tooltip
                tip.hide(d);
            });

        // Animate chart on load
        arcPath
            .transition()
                .delay(function(d, i) { return i * 500; })
                .duration(500)
                .attrTween("d", function(d) {
                    var interpolate = d3.interpolate(d.startAngle,d.endAngle);
                    return function(t) {
                        d.endAngle = interpolate(t);
                        return arc(d);  
                    }; 
                });
    }

    // Initialize charts

   // generateBarChart("#members-online", 24, 50, true, "elastic", 1200, 50, "rgba(255,255,255,0.5)", "members");

    // Chart setup
    function generateBarChart(element, barQty, height, animate, easing, duration, delay, color, tooltip){
        /*var bardata = [];
        for (var i=0; i < barQty; i++) {
            bardata.push(Math.round(Math.random()*10) + 10)
        }
        console.log(bardata);*/
     
        $.ajax({  
            dataType: 'json',
            url: 'ajax/ajax_dashboard.php',
            success:  function (response) {
                var bardata1=response.arr_datos2;
                var bardata= [];
                for (var i = 0; i < bardata1.length; i++) {
                    //bardata2[i][1]
                    //console.log( bardata2[i][1]);
                    bardata.push(bardata1[i][1]);
                }

        // Main variables
        var d3Container = d3.select(element),
            width = d3Container.node().getBoundingClientRect().width;

        // Horizontal
        var x = d3.scale.ordinal()
            .rangeBands([0, width], 0.3)

        // Vertical
        var y = d3.scale.linear()
            .range([0, height]);

        // Horizontal
        x.domain(d3.range(0, bardata.length))

        // Vertical
        y.domain([0, d3.max(bardata)])

        // Add svg element
        var container = d3Container.append('svg');

        // Add SVG group
        var svg = container
            .attr('width', width)
            .attr('height', height)
            .append('g');

        // Bars
        var bars = svg.selectAll('rect')
            .data(bardata)
            .enter()
            .append('rect')
                .attr('class', 'd3-random-bars')
                .attr('width', x.rangeBand())
                .attr('x', function(d,i) {
                    return x(i);
                })
                .style('fill', color);

        var tip = d3.tip()
            .attr('class', 'd3-tip')
            .offset([-10, 0]);

        // Show and hide
        if(tooltip == "hours" || tooltip == "goal" || tooltip == "members") {
            bars.call(tip)
                .on('mouseover', tip.show)
                .on('mouseout', tip.hide);
        }

        // Daily meetings tooltip content
        if(tooltip == "hours") {
            tip.html(function (d, i) {
                return "<div class='text-center'>" +
                        "<h6 class='no-margin'>" + d + "</h6>" +
                        "<span class='text-size-small'>logeos</span>" +
                        "<div class='text-size-small'>" + i + ":00" + "</div>" +
                    "</div>"
            });
        }

        // Statements tooltip content
        if(tooltip == "goal") {
            tip.html(function (d, i) {
                return "<div class='text-center'>" +
                        "<h6 class='no-margin'>" + d + "</h6>" +
                        "<span class='text-size-small'>accesos</span>" +
                        "<div class='text-size-small'>" + i + ":00" + "</div>" +
                    "</div>"
            });
        }

        // Online members tooltip content
        if(tooltip == "members") {
            tip.html(function (d, i) {
                return "<div class='text-center'>" +
                        "<h6 class='no-margin'>" + d + "</h6>" +
                        "<span class='text-size-small'>visitas</span>" +
                        "<div class='text-size-small'>" + i + ":00" + "</div>" +
                    "</div>"
            });
        }

        // Choose between animated or static
        if(animate) {
            withAnimation();
        } else {
            withoutAnimation();
        }


        // Animate on load
        function withAnimation() {
            bars
                .attr('height', 0)
                .attr('y', height)
                .transition()
                    .attr('height', function(d) {
                        return y(d);
                    })
                    .attr('y', function(d) {
                        return height - y(d);
                    })
                    .delay(function(d, i) {
                        return i * delay;
                    })
                    .duration(duration)
                    .ease(easing);
        }

        // Load without animateion
        function withoutAnimation() {
            bars
                .attr('height', function(d) {
                    return y(d);
                })
                .attr('y', function(d) {
                    return height - y(d);
                })
        }

        // Call function on window resize
        $(window).on('resize', barsResize);

        // Call function on sidebar width change
        $(document).on('click', '.sidebar-control', barsResize);

                function barsResize() {

                    // Layout variables
                    width = d3Container.node().getBoundingClientRect().width;

                    // Main svg width
                    container.attr("width", width);

                    // Width of appended group
                    svg.attr("width", width);

                    // Horizontal range
                    x.rangeBands([0, width], 0.3);
                    // Bars
                    svg.selectAll('.d3-random-bars')
                        .attr('width', x.rangeBand())
                        .attr('x', function(d,i) {
                            return x(i);
                        });
                }
        /**END AJAX*/
           }
        });
    }

    // Initialize charts

   $.ajax({  
        dataType: 'json',
        url: 'ajax/ajax_dashboard.php',
        success:  function (response) {
            var x=response.arr_datos1;
            var usuarios_totalizar=(x[1][0]/150);
            
           console.log(response.arr_datos1[1][0]);
           
            progressCounter('#hours-available-progress', 38, 4, "#F06292", usuarios_totalizar, "icon-users text-pink-400", 'Usuarios', x[1][0]+' Activos')
            
           /* progressCounter('#goal-progress', 38, 4, "#5C6BC0", ficheros_totalizar, "icon-trophy3 text-indigo-400", 'Ficheros', 'CloudFile')
            progressCounter('#g-progress', 38, 4, "#F4B84E", contacto_totalizar, "icon-file-text text-orange-400", 'ContactCenter', 'Sumarizado')*/
        }
    });
    // Chart setup
    function progressCounter(element, radius, border, color, end, iconClass, textTitle, textAverage) {
        var d3Container = d3.select(element),
            startPercent = 0,
            iconSize = 32,
            endPercent = end,
            twoPi = Math.PI * 2,
            formatPercent = d3.format('.0%'),
            boxSize = radius * 2;

        // Values count
        var count = Math.abs((endPercent - startPercent) / 0.01);

        // Values step
        var step = endPercent < startPercent ? -0.01 : 0.01;

        var container = d3Container.append('svg');

        // Add SVG group
        var svg = container
            .attr('width', boxSize)
            .attr('height', boxSize)
            .append('g')
                .attr('transform', 'translate(' + (boxSize / 2) + ',' + (boxSize / 2) + ')');

        var arc = d3.svg.arc()
            .startAngle(0)
            .innerRadius(radius)
            .outerRadius(radius - border);


        svg.append('path')
            .attr('class', 'd3-progress-background')
            .attr('d', arc.endAngle(twoPi))
            .style('fill', '#eee');

        // Foreground path
        var foreground = svg.append('path')
            .attr('class', 'd3-progress-foreground')
            .attr('filter', 'url(#blur)')
            .style('fill', color)
            .style('stroke', color);

        // Front path
        var front = svg.append('path')
            .attr('class', 'd3-progress-front')
            .style('fill', color)
            .style('fill-opacity', 1);


        var numberText = d3.select(element)
            .append('h2')
                .attr('class', 'mt-15 mb-5')

        // Icon
        d3.select(element)
            .append("i")
                .attr("class", iconClass + " counter-icon")
                .attr('style', 'top: ' + ((boxSize - iconSize) / 2) + 'px');

        // Title
        d3.select(element)
            .append('div')
                .text(textTitle);

        // Subtitle
        d3.select(element)
            .append('div')
                .attr('class', 'text-size-small text-muted')
                .text(textAverage);

        function updateProgress(progress) {
            foreground.attr('d', arc.endAngle(twoPi * progress));
            front.attr('d', arc.endAngle(twoPi * progress));
            numberText.text(formatPercent(progress));
        }

        // Animate text
        var progress = startPercent;
        (function loops() {
            updateProgress(progress);
            if (count > 0) {
                count--;
                progress += step;
                setTimeout(loops, 10);
            }
        })();
    }

    // Grab first letter and insert to the icon
    $(".table tr").each(function (i) {

        // Title
        var $title = $(this).find('.letter-icon-title'),
            letter = $title.eq(0).text().charAt(0).toUpperCase();

        // Icon
        var $icon = $(this).find('.letter-icon');
            $icon.eq(0).text(letter);
    });

});

function marcadores_dash() {
        $.ajax({
            data: {},
            dataType: 'json',
            url: 'ajax/ajax_dashboard.php',
            success:  function (response) {                             
                if (response.codigo==0){
                    swal({ title: "Mensaje del Sistema",text:response.mensaje,type:"warning"});
                }else if (response.codigo==2){
                    swal({   title: "Mensaje del Sistema",text: response.mensaje,type:"info"});
                    setTimeout(function() {
                        window.location='index.php';
                    }, 2000);
                }else{          
                    $("#dash_user").text(response.arr_datos[0][0]);
                    $("#dash_fecha").text(response.arr_datos[0][2]);
                   // $("#dash_logeos").text(response.arr_datos1[0][0]);
                  //  $("#dash_logeos_year").text(response.arr_datos1[3][0]);
                   // $("#dash_proyectos").text(response.arr_datos1[4][0]);

                }
            }
        });
}
