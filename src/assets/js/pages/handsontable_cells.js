
$(function() {
    
     init();
     
    function init(){
    
    var valida=4;
    var agua=$("#btn_agua" ).text();
    var alcantarilla=$("#btn_alcan" ).text();
    var ano =  jQuery('#ano').val();
                
    var datos =Array();
    $.ajax({
			data: {valida:valida,agua:agua,alcantarilla:alcantarilla,ano:ano},
			dataType: 'json',
			url: 'ajax/ajax_contacto.php',
			success:  function (response) {
			if (response.codigo==0){
					swal({   title: "Mensaje del Sistema",   text: response.mensaje,    type: "warning" });
			}else{
			   // console.log(response.arr_datos);
				datos.push({  id: '', edificio: '', depa: '', enero:'Enero' , enero_1: '',enero2: '',enero3: '',febrero:'Febrero', febrero_1: '',febrero2:'',febrero3:'',febrero4:'',marzo:'Marzo',marzo_1:'',marzo2:'',marzo3:'',marzo4:'',abril:'Abril',abril_1:'',abril2:'',abril3:'',abril4:'',mayo:'Mayo',mayo_1:'',mayo2:'',mayo3:'',mayo4:''})
				for(var i=0; i < response.arr_datos.length; i++){
						datos.push({  id: parseFloat(response.arr_datos[i][0]), edificio: response.arr_datos[i][1], dep: response.arr_datos[i][2], enero: response.arr_datos[i][3], enero_1: response.arr_datos[i][4], enero2: response.arr_datos[i][5], enero3: response.arr_datos[i][6],enero4: response.arr_datos[i][7],febrero: response.arr_datos[i][8],febrero_1: response.arr_datos[i][9],febrero2: response.arr_datos[i][10],febrero3: response.arr_datos[i][11],febrero4: response.arr_datos[i][12],marzo: response.arr_datos[i][13],marzo_1: response.arr_datos[i][14],marzo2: response.arr_datos[i][15],marzo3: response.arr_datos[i][16] ,marzo4: response.arr_datos[i][17],abril: response.arr_datos[i][18],abril_1: response.arr_datos[i][19],abril2: response.arr_datos[i][20],abril3: response.arr_datos[i][21],abril4: response.arr_datos[i][22],mayo: response.arr_datos[i][23],mayo_1: response.arr_datos[i][24],mayo2: response.arr_datos[i][25],mayo3: response.arr_datos[i][26],mayo4: response.arr_datos[i][27]})
				}
				//console.log(datos);	
			}
		}
	});
	
	 
    // Define element
    var hot_validation = document.getElementById('hot_validation'),

    // Define output element
    hot_validation_console = document.getElementById('hot_validation_console');


    // Email validator
    var ipValidatorRegexp = /^(?:\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b|null)$/;
    var emailValidator = function (value, callback) {
        setTimeout(function() {
            if (/.+@.+/.test(value)) {
                callback(true);
            }
            else {
                callback(false);
            }
        }, 1000);
    };
    
     // Initialize with options
    var hot_validation_init = new Handsontable(hot_validation, {
        data: datos,
        colWidths: 70,
          width: '100%',
          height: 320,
          rowHeights: 23,
          search: true,
          rowHeaders: true,
          colHeaders: true,
        afterSelection: function (row, col, row2, col2) {
            var meta = this.getCellMeta(row2, col2);

            if (meta.readOnly) {
                this.updateSettings({fillHandle: false});
            }
            else {
                this.updateSettings({fillHandle: true});
            }
        },
        beforeChange: function (changes, source) {
            
            for (var i = changes.length - 1; i >= 0; i--) {
                if (changes[i][3] >= changes[i][5] || changes[i][5] >= changes[i][7]) {
                    return false;
                }else if (changes[i][3] <=0 && changes[i][5] <=0 && changes[i][7] <=0) {
                    return false;
                }
            }
        },
        afterChange: function (changes, source) {
            
            if (source !== 'loadData') {
                hot_validation_console.innerText = JSON.stringify(changes);
                Prism.highlightElement(hot_validation_console);
                
                
                var valida=5;
                var id=changes[0][0];
                var campo=changes[0][1];
                var valor=changes[0][3];
                var ano =  jQuery('#ano').val();
                
                changes.forEach(function(changes) {
                //console.log(hot_validation_init.getSourceDataAtCol('marzo'));
                var id2=(hot_validation_init.getDataAtCell(id,0));
                    $.ajax({
                			data: {valida:valida,id2:id2,campo:campo,valor:valor,ano:ano},
                			dataType: 'json',
                			url: 'ajax/ajax_contacto.php',
                			success:  function (response) {
                    			if (response.codigo==0){
                    				console.log(response.mensaje);
                    				//window.location='contometro.php';  
                    				
                    			}else{
                    				console.log(this);
                                    init();
                    			}
                		    }
                	    })
                	   
                 
                //console.log(id2);
                })
            }
        },
        colHeaders: ['Id', 'Edificio', 'Unidad','Lectura','Consumo','Agua','Alcant.','Total','Lectura','Consumo','Agua','Alcant.','Total','Lectura','Consumo','Agua','Alcant.','Total','Lectura','Consumo','Agua','Alcant.','Total','Lectura','Consumo','Agua','Alcant.','Total'],
        columns: [
            {data: 'id', type: 'numeric', className: 'htLeft', readOnly: true},
            {data: 'edificio', readOnly: true},
            {data: 'dep', readOnly: true},
            {data: 'enero', type: 'numeric', className: 'htLeft', format: '0,0.000'},
            {data: 'enero_1', type: 'numeric', className: 'htLeft', format: '0,0.000'},
            {data: 'enero2', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'enero3', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'enero4', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'febrero', type: 'numeric', className: 'htLeft', format: '0,0.000'},
            {data: 'febrero_1', type: 'numeric', className: 'htLeft', format: '0,0.000'},
            {data: 'febrero2', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'febrero3', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
             {data: 'febrero4', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'marzo', type: 'numeric', className: 'htLeft', format: '0,0.000'},
            {data: 'marzo_1', type: 'numeric', className: 'htLeft', format: '0,0.000'},
            {data: 'marzo2', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'marzo3', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'marzo4', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'abril', type: 'numeric', className: 'htLeft', format: '0,0.000'},
            {data: 'abril_1', type: 'numeric', className: 'htLeft', format: '0,0.000'},
            {data: 'abril2', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'abril3', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'abril4', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'mayo', type: 'numeric', className: 'htLeft', format: '0,0.000'},
            {data: 'mayo_1', type: 'numeric', className: 'htLeft', format: '0,0.000'},
            {data: 'mayo2', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'mayo3', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true},
            {data: 'mayo4', type: 'numeric', className: 'htLeft', format: '$0,0.00',readOnly: true}
            /*,
            {data: 'ip', validator: ipValidatorRegexp, allowInvalid: true},
            {data: 'email', validator: emailValidator, allowInvalid: false}*/
        ],
        //colWidths: [5, 20, 20, 10, 10, 10, 10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10],
         mergeCells: [
            {row: 0, col: 3, rowspan: 1, colspan: 5},
            {row: 0, col: 8, rowspan: 1, colspan: 5},
            {row: 0, col: 13, rowspan: 1, colspan: 5},
            {row: 0, col: 18, rowspan: 1, colspan: 5},
            {row: 0, col: 23, rowspan: 1, colspan: 5}
          ]
          
          
    });

    
   
    
    hot_validation_init.updateSettings({
      	 cells: function(row, col, prop){
        	var cellProperties = {};
          	if(hot_validation_init.getDataAtCell(row, col) === 'Enero' || hot_validation_init.getDataAtCell(row, col) === 'Febrero' || hot_validation_init.getDataAtCell(row, col) === 'Marzo' || hot_validation_init.getDataAtCell(row, col) === 'Abril' || hot_validation_init.getDataAtCell(row, col) === 'Mayo'){
            	cellProperties.disabled = 'true'
            }
            
            if (hot_validation_init.getDataAtCell(row, col) ==='0.000') {
                cellProperties.className = 'text-danger';
            }
            

            if (row === 0 || this.instance.getData()[row][col] === 'Read only') {
                cellProperties.readOnly = true; // make cell read-only if it is first row or the text reads 'readOnly'
            }
            if (row === 0 || col === 0) {
                cellProperties.renderer = firstRowRenderer; // uses function directly
            }


            //console.log(hot_validation_init.getDataAtCell(row, col));
          return cellProperties
        }
      })
      
      
       // Header row renderer
    function firstRowRenderer(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);

        // Add styles to the table cell
        td.style.fontWeight = '500';
        td.style.color = '#1B5E20';
        td.style.background = '#E8F5E9';
    }
    
 
    
       // Define search field
    var hot_search_basic_input = document.getElementById('hot_search_callback_input');

    // Setup matching function
    function onlyExactMatch(queryStr, value) {
        return queryStr.toString() === value.toString();
    }

    // Add event
    Handsontable.Dom.addEvent(hot_search_basic_input, 'keyup', function (event) {
        var queryResult = hot_validation_init.search.query(this.value);
        //console.log(hot_validation_init.search.query(this.value));
        console.log(queryResult);
        hot_validation_init.render();
    });
  
    
      
}

});
