var TableEditable = function() {
    var cars = [];
    var playerscoreTable = function() {
        function delData(delval) {
            var dataString = JSON.stringify(delval);
            var clone = document.getElementById('clone').value;
            if (clone == "clone") {
                var clone_pid = document.getElementById('clone_pid').value;
                var clone_sid = document.getElementById('clone_sid').value;
            } else {
                var clone_pid = '';
                var clone_sid = '';
            }
            $.ajax({
                url: "gamedata_db.php",
                type: "POST",
                data: {myData: dataString, myaction: 'delete', player_id: document.getElementById('pid').value, sports_id: document.getElementById('sid').value, clone: clone, clone_pid: clone_pid, clone_sid: clone_sid},
                dataType: 'json',
                cache: false,
                success: function(result) {
                    if (result)
                    {
                        if (clone == "clone") {
                            //document.getElementById('clone').value = 'none';
                            location.reload();
                        }
                        alert("Deleted successfully!");
                    }
                }
            });
        }
        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }
            oTable.fnDraw();
        }
//        function editCell(oTable, nRow) {
//            
//            var aData = $(oTable).children("td");
//            var jqTds = $('>td', nRow);
//            
//            console.log(jqTds);
//            console.log(aData);
//            
//            var cellValue = $("#tableID").dataTable().fnGetData(rowData[0], colIndex);
//            for (var c = 0; c < aData.length; c++) {
//                jqTds[c].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[c] + '">';
//            }
////            $(this).innerHTML = '<input type="text" class="form-control input-small" value="' + $(this).value + '">';
//        }
        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            for (var c = 0; c < aData.length - 2; c++) {
                jqTds[c].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[c] + '">';
            }
            jqTds[aData.length - 2].innerHTML = '<a class="edit" href="">Save</a>';
            jqTds[aData.length - 1].innerHTML = '<a class="cancel" href="">Cancel</a>';
        }
        function saveRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow); //by me
            var jqInputs = $('input', nRow);
            var jqTds = $('>td', nRow); //by me
            cars = [];
            for (var c = 0; c < aData.length - 2; c++) {
                oTable.fnUpdate(jqInputs[c].value, nRow, c, false);
                $(jqTds[c]).each(function() {
                    var temp = $(this).closest('td').attr('id') + '_&_' + jqInputs[c].value;
                    cars.push(temp);
                });
            }
            oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, aData.length - 2, false);
            oTable.fnUpdate('<a class="delete" href="">Delete</a>', nRow, aData.length - 1, false);
            oTable.fnDraw();
        }
        function cancelEditRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqInputs = $('input', nRow);
            for (var c = 0; c < aData.length - 2; c++) {
                oTable.fnUpdate(jqInputs[c].value, nRow, c, false);
            }
            oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, aData.length - 2, false);
            oTable.fnDraw();
        }
        var table = $('#gamedata');
        var oTable = table.dataTable({
            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 25,
            "language": {
                "lengthMenu": " _MENU_ records"
            },
            "columnDefs": [{// set default column settings
                    'orderable': true,
                    'targets': [0]
                }, {
                    "searchable": false,
                    "targets": [0]
                }],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });
        var tableWrapper = $("#gamedata_wrapper");
//        tableWrapper.find(".dataTables_length select").select2({
//            showSearchInput: false //hide search box with special css class
//        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        $(function() {
            $("#gamedata tr td").dblclick(function(e) {
                e.stopPropagation();
                var currentEle = $(e.target);
                var value = $(e.target).html();
//                console.log($(e.target));
                if ($.trim(value) === "") {
                    $(currentEle).data('mode', 'add');
                } else {
                    $(currentEle).data('mode', 'edit');
                }
                var gid = $(this).attr('id');
                updateVal(currentEle, value, gid);
            });
        });

        function updateVal(currentEle, value, gid) {
            $(currentEle).html('<input class="form-control input-small thVal" type="text" value="' + value.trim() + '" />');
            var mode = $(currentEle).data('mode');
            var clone = document.getElementById('clone').value;
            if (clone == "clone") {
                var clone_pid = document.getElementById('clone_pid').value;
                var clone_sid = document.getElementById('clone_sid').value;
            } else {
                var clone_pid = '';
                var clone_sid = '';
            }
            $(".thVal").focus();
            $(".thVal").keyup(function(event) {
                $.ajax({
                    url: "gamedata_db.php",
                    type: "POST",
                    data: {gid: gid, tdval: $(this).val().trim(), myaction: 'Cell', player_id: document.getElementById('pid').value, sports_id: document.getElementById('sid').value, clone: clone, clone_pid: clone_pid, clone_sid: clone_sid},
                    dataType: 'json',
                    cache: false,
                    success: function(result) {
                        if (clone == "clone") {
                            //document.getElementById('clone').value = 'none';
                            location.reload();
                        }
//                        alert("Updated successfully!");
                    }
                });
                if (event.keyCode == 13) {
//                    alert("Updated successfully!");
                    $(this).parent().html($(this).val().trim());
                    $(".thVal").remove();
                }
            });
        }

        $(document).click(function(e) {
            if ($(".thVal") !== undefined) {
                if ($(".thVal").val() !== undefined) {
                    $(".thVal").parent().html($(".thVal").val().trim());
                    $(".thVal").remove();
                }
            }
        });

        $('#gamedata_new').click(function(e) {
            document.getElementById('myaction').value = 'Add';
            e.preventDefault();
            if (nNew && nEditing) {
                var actionType = document.getElementById('myaction').value;
                if (confirm("previous row not saved. Do you want to save it ?")) {
                    saveRow(oTable, nEditing); // save
                    $(nEditing).find("td:first").html("Untitled");
                    nEditing = null;
                    nNew = false;
                } else {
                    oTable.fnDeleteRow(nEditing); // cancel
                    nEditing = null;
                    nNew = false;
                    return;
                }
            }
            var temp = parseFloat(document.getElementById('hdn').value);
            var aiNew1 = [];
            for (var c = 0; c < temp + 2; c++) {
                aiNew1[c] = "";
            }
            var aiNew = oTable.fnAddData(aiNew1);
//            var aiNew = oTable.fnAddData(['', '', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        table.on('click', '.delete', function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to delete record?") == false) {
                return;
            }
            var delValues = $(this).attr('id');
            delData(delValues);

            var nRow = $(this).parents('tr')[0];
            oTable.fnDeleteRow(nRow);
////            alert("Deleted! Do not forget to do some ajax to sync with backend :)");
        });

        table.on('click', '.cancel', function(e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });
        table.on('click', '.edit', function(e) {
            e.preventDefault();
            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];
            if (nEditing !== null && nEditing != nRow) {
                document.getElementById('myaction').value = 'Edit';
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == "Save") {
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);
                nEditing = null;
                //alert("Updated! Do not forget to do some ajax to sync with backend :)");
                var dataString = JSON.stringify(cars);
                var actionType = document.getElementById('myaction').value;
                var clone = document.getElementById('clone').value;
                if (clone == "clone") {
                    var clone_pid = document.getElementById('clone_pid').value;
                    var clone_sid = document.getElementById('clone_sid').value;
                } else {
                    var clone_pid = '';
                    var clone_sid = '';
                }
                if (actionType == 'Add') {
                    $.ajax({
                        url: "gamedata_db.php",
                        type: "POST",
                        data: {myData: dataString, myaction: 'Add', player_id: document.getElementById('pid').value, sports_id: document.getElementById('sid').value, clone: clone, clone_pid: clone_pid, clone_sid: clone_sid},
                        dataType: 'json',
                        cache: false,
                        success: function(result) {
                            if (clone == "clone") {
                                //document.getElementById('clone').value = 'none';
                                location.reload();
                            }
                            alert("Added successfully!");
                        }
                    });
                } else {
                    $.ajax({
                        url: "gamedata_db.php",
                        type: "POST",
                        data: {myData: dataString, myaction: 'update', player_id: document.getElementById('pid').value, sports_id: document.getElementById('sid').value, clone: clone, clone_pid: clone_pid, clone_sid: clone_sid},
                        dataType: 'json',
                        cache: false,
                        success: function(result) {
                            if (clone == "clone") {
                                //document.getElementById('clone').value = 'none';
                                location.reload();
                            }
                            alert("Updated successfully!");
                        }
                    });

                }
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            playerscoreTable();
        }

    };

}();