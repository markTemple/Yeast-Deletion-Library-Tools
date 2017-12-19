<body>
<?php echo '<div id="venn'.$divID.'"></div>';?>				 
</b
></body>
<!--<style>
.venntooltip {
  position: absolute;
  text-align: center;
  width: 128px;
  height: 16px;
  background: #333;
  color: #ddd;
  padding: 2px;
  border: 0px;
  border-radius: 8px;
  opacity: 0;
}
</style>
-->
<!--<script src="http://d3js.org/d3.v3.min.js"></script>-->
<script>
<?php echo 'var chart = venn.VennDiagram().width('.$wdth.').height('.$hght.');';?>				 
// define sets and set set intersections


//strange line return??
<?php echo 'var div = d3.select("#venn'.$divID.'");';?>		
div.datum(sets).call(chart);	 


/*var tooltip = d3.select("body").append("div")
    .attr("class", "venntooltip");

div.selectAll("path")
    .style("stroke-opacity", 0)
    .style("stroke", "#fff")
    .style("stroke-width", 0)

div.selectAll("g")
    .on("mouseover", function(d, i) {
        // sort all the areas relative to the current item
        venn.sortAreas(div, d);

        // Display a tooltip with the current size
        tooltip.transition().duration(400).style("opacity", .9);
        tooltip.text(d.size + " deletants" );
        
        // highlight the current path
        var selection = d3.select(this).transition("tooltip").duration(400);
        selection.select("path")
            .style("stroke-width", 3)
            .style("fill-opacity", d.sets.length == 1 ? .4 : .1)
            .style("stroke-opacity", 1);
    })

    .on("mousemove", function() {
        tooltip.style("left", (d3.event.pageX) + "px")
               .style("top", (d3.event.pageY - 28) + "px");
    })
    
    .on("mouseout", function(d, i) {
        tooltip.transition().duration(400).style("opacity", 0);
        var selection = d3.select(this).transition("tooltip").duration(400);
        selection.select("path")
            .style("stroke-width", 0)
            .style("fill-opacity", d.sets.length == 1 ? .25 : .0)
            .style("stroke-opacity", 0);
    });*/
   </script>

