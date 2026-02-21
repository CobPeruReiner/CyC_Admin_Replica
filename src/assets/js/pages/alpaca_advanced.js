
$(function() {

    // Option trees
    // ------------------------------

    // Option tree field
    seleccionando();

    /*
    $("#alpaca-option-tree").alpaca({
        "schema": {
            "type": "number",
            "title": ""
        },
        "options": {
            "type": "optiontree",
            "tree": {
                "selectors": {
                    "sector": {
                        "schema": {
                            "type": "string"
                        },
                        "options": {
                            "type": "select",
                            "noneLabel": "Seleccione..."
                        }
                    },
                    "norma": {
                        "schema": {
                            "type": "string"
                        },
                        "options": {
                            "type": "select",
                            "noneLabel": "Seleccione..."
                        }
                    }
                },
                "order": ["sector", "norma"],
                
                "data":  [{
                    "value": 23,
                    "attributes": {
                        "sector": "Calidad",
                        "norma": "20001"
                    }
                }, {
                    "value": 33,
                    "attributes": {
                        "sector": "Calidad",
                        "norma": "8001"
                    }
                }, {
                    "value": 4,
                    "attributes": {
                        "sector": "Medio Ambiente",
                        "norma": "14000"
                    }
                }, {
                    "value": 19,
                    "attributes": {
                        "sector": "Medio Ambiente",
                        "norma": "21000"
                    }
                }, {
                    "value": 99,
                    "attributes": {
                        "sector": "Software",
                        "norma": "1212"
                    }
                }],
                "horizontal": true
            },
            "focus": false
        },
        "postRender": function(control) {
            $('#alpaca2').select2();
        }
    });
*/

    // Using connector
  $("#alpaca-option-tree-connector").alpaca({
        "schemaSource": "http://127.0.0.1/system_amv/assets/demo_data/alpaca/optiontree-custom-schema.json",
        "optionsSource": "http://127.0.0.1/system_amv/assets/demo_data/alpaca/optiontree-custom-options.json",
        "options": {
            "focus": false
        }
    });



    // Input types
    // ------------------------------

    // Lowercase
    $("#alpaca-lowercase").alpaca({
        "data": "Ice cream is wonderful.",
        "schema": {
            "format": "lowercase"
        },
        "options": {
            "focus": false
        }
    });


    // Uppercase
    $("#alpaca-uppercase").alpaca({
        "data": "Ice cream is wonderful.",
        "schema": {
            "format": "uppercase"
        },
        "options": {
            "focus": false
        }
    });


    // Search type
    $("#alpaca-search").alpaca({
        "data": "Where for art thou Romeo?",
        "schema": {
            "type": "string"
        },
        "options": {
            "type": "search",
            "focus": false,
            "label": "Search"
        }
    });

     
    // Integer type
    $("#alpaca-version").alpaca({
        "data": "0",
        "options": {
            "type": "number",
            "label": "",
            /*"focus": true,
            "required": true,*/
            "id": "alpaca-version_text",
            "helper": "Ingrese rango versión: 1-20"
        },
        "schema": {
            "minimum": 0,
            "maximum": 21,
            "exclusiveMinimum": true,
            "exclusiveMaximum": true/*,
            "divisibleBy": 0*/
        },
        "postRender": function(control) {
            //$('.alpaca-control').attr('required', 'required');
           //$('#alpaca-version_text').attr('required', 'required');
        }
    });


    // Password type
    $("#alpaca-password").alpaca({
        "data": "password",
        "schema": {
            "format": "password"
        },
        "options": {
            "focus": false
        }
    });


    // Email type
    $("#alpaca-email").alpaca({
        "data": "support",
        "schema": {
            "format": "email"
        },
        "options": {
            "focus": false
        }
    });


    // IP address type
    $("#alpaca-ipv4").alpaca({
        "data": "100.60",
        "schema": {
            "format": "ip-address"
        },
        "options": {
            "focus": false
        }
    });


    // URL type
    $("#alpaca-url").alpaca({
        "data": "http://www.alpacajs.org",
        "options": {
            "type": "url",
            "focus": false
        },
        "schema": {
            "format": "uri"
        }
    });


    // Currency type
    $("#alpaca-currency").alpaca({
        "options": {
            "type": "currency",
            "focus": false
        }
    });


    // Personal name type
    $("#alpaca-name").alpaca({
        "data": "Oscar Zoroaster Phadrig Isaac Norman Henkel Emmannuel Ambroise Diggs",
        "options": {
            "type": "personalname",
            "focus": false
        }
    });



    // File inputs
    // ------------------------------

    // Basic file input
    $("#alpaca-file").alpaca({
        "data": "",
        "options": {
            "type": "file",
            "label": "Ice Cream Photo:",
            "helper": "Pick your favorite ice cream picture.",
            "focus": false
        },
        "schema": {
            "type": "string",
            "format": "uri"
        }
    });


    // Static mode
    $("#alpaca-file-static").alpaca({
        "data": "/abc.html",
        "options": {
            "type": "file",
            "label": "Ice Cream Photo:",
            "helper": "Pick your favorite ice cream picture.",
            "focus": false
        },
        "schema": {
            "type": "string",
            "format": "uri"
        },
        "view": "bootstrap-display"
    });


    // Styled file input
    $("#alpaca-file-styled").alpaca({
        "data": "",
        "options": {
            "type": "file",
            "label": "Ice Cream Photo:",
            "helper": "Pick your favorite ice cream picture.",
            "id": "file-styled",
            "focus": false
        },
        "schema": {
            "type": "string",
            "format": "uri"
        },
        "postRender": function(control) {
            $("#file-styled").uniform({
                fileButtonClass: 'action btn bg-blue'
            });
        }
    });


    // Disabled file input
    $("#alpaca-file-disabled").alpaca({
        "data": "",
        "options": {
            "type": "file",
            "label": "Ice Cream Photo:",
            "helper": "Pick your favorite ice cream picture.",
            "disabled": true,
            "id": "file-styled-disabled",
            "focus": false
        },
        "schema": {
            "type": "string",
            "format": "uri"
        },
        "postRender": function(control) {
            $("#file-styled-disabled").uniform({
                fileButtonClass: 'action btn bg-blue'
            });
        }
    });



    // Selector helpers
    // ------------------------------

    // Country selector
    $("#alpaca-country").alpaca({
        "options": {
            "type": "country",
            "focus": false
        }
    });


    // Searchable country selector
    $("#alpaca-country-search").alpaca({
        "options": {
            "type": "country",
            "id": "country-search",
            "focus": false
        },
        "postRender": function(control) {
            $('#country-search').select2();
        }
    });


    // State selector
    $("#alpaca-state").alpaca({
        "options": {
            "type": "state",
            "focus": false
        }
    });

    // Searchable state selector
    $("#alpaca-state-search").alpaca({
        "options": {
            "type": "state",
            "id": "state-search",
            "focus": false
        },
        "postRender": function(control) {
            $('#state-search').select2();
        }
    });



    // CKEditor
    // ------------------------------

    // Full featured CKEditor
    $("#alpaca-ckeditor-full").alpaca({
        "data": "Ice cream is a <b>frozen</b> dessert usually made from <i>dairy products</i>, such as milk and cream, and often combined with fruits or other ingredients and flavors.",
        "options": {
            "type": "ckeditor"
        }
    });

   

});

function seleccionando(){
    $.ajax({
            dataType: 'json',
            url: 'ajax/ajax_select.php',
            success:  function (response) {
                
                    if (response.codigo==0){
                    swal({   title: "Mensaje del Sistema",   text: response.mensaje,    type: "warning" });
                
                    }else{
                        var datos_bar =new Array();         
                        for (var i=0; i < response.arr_datos_select.length; i++) {
                                    datos_bar.push({  value: response.arr_datos_select[i][0], attributes : { sector: response.arr_datos_select[i][1], norma: response.arr_datos_select[i][2]} })
                            }
                        //console.log(datos_bar);
                        
                            $("#alpaca-option-norma").alpaca({
                                "schema": {
                                    "type": "number",
                                    "required":"required",
                                    "title": ""
                                },
                                "options": {
                                    "type": "optiontree",
                                    "id": "alpaca-norma_text",
                                    "tree": {
                                        "selectors": {
                                            "sector": {
                                                "schema": {
                                                    "type": "string"
                                                },
                                                "options": {
                                                    "type": "select",
                                                    "id": "alpaca-norma_sector",
                                                    "noneLabel": "Seleccione..."
                                                },
                                                "postRender": function(control) {
       
                                                }
                                            },
                                            "norma": {
                                                "schema": {
                                                    "type": "string"
                                                },
                                                "options": {
                                                    "type": "select",
                                                    "id": "alpaca-norma_iso",
                                                    "noneLabel": "Seleccione..."
                                                },
                                                "postRender": function(control) {
                               
                                                }
                                            }
                                        },
                                        "order": ["sector", "norma"],
                                        
                                        "data":datos_bar,
                                        
                                        "horizontal": true
                                    },
                                    "focus": false
                                },
                                "postRender": function(control) {
                                    //$('#alpaca-norma_sector').select2();
                                    $("#alpaca-norma_text").prop('readonly', true);
                                    $('#alpaca-norma_text').attr('required', 'required');


                                }
                            });

                    }
            }
    });
}       