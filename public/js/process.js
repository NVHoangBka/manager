/* global cytoscape, cytoscapeEdgehandles, elementsProduction, elementsQuality, elementsOrder, elementsSewing, $ */


// plugin
cytoscape.use(cytoscapeEdgehandles);

$(document).ready(function() {

    var cyInstances  = {};
    var selectedNode = null;
    var selectedEdge = null;
    var selectedColor = '#007bff';
    var edgeHandleOn = false;

    var typeMap = {
        '#tab-production': { id: 'cy-production', type: 'production', els: elementsProduction },
        '#tab-quality':    { id: 'cy-quality',    type: 'quality',    els: elementsQuality    },
        '#tab-order':      { id: 'cy-order',      type: 'order',      els: elementsOrder      },
        '#tab-sewing':     { id: 'cy-sewing',     type: 'sewing',     els: elementsSewing     }
    };
    
    var ehStyles = [
        {
            selector: '.eh-handle',
            style: {
                'background-color': '#28a745',
                'width': 12, 'height': 12,
                'shape': 'ellipse',
                'overlay-opacity': 0,
                'border-width': 0
            }
        },
        { 
            selector: '.eh-hover',                      
            style: { 
                'background-color': '#28a745' 
            } 
        },
        { 
            selector: '.eh-source',                     
            style: { 
                'border-width': 3, 
                'border-color': '#28a745' 
            } 
        },
        { 
            selector: '.eh-target',                     
            style: { 
                'border-width': 3, 
                'border-color': '#28a745' 
            } 
        },
        { 
            selector: '.eh-preview, .eh-ghost-edge',    
            style: { 
                'line-color': '#28a745', 
                'target-arrow-color': '#28a745', 
                'target-arrow-shape': 'triangle' 
            } 
        }
    ];
    
    var styleDefault = [
        {
            selector: 'node',
            style: {
                'label':            'data(label)',
                'text-valign':      'center',
                'text-halign':      'center',
                'color':            '#fff',
                'font-size':        '11px',
                'font-weight':      'bold',
                'text-wrap':        'wrap',
                'text-max-width':   '110px',
                'width':            '130px',
                'height':           '50px',
                'shape':            'roundrectangle',
                'background-color': 'data(color)',
                'border-width':     '0px'
            }
        },
        {
            selector: 'node[color = "#f5a623"]',
            style: { 'width': '36px', 'height': '36px', 'shape': 'rectangle', 'font-size': '13px' }
        },
        {
            selector: 'node[type = "decision"]',
            style: { 'shape': 'diamond', 'width': '110px', 'height': '65px' }
        },
        {
            selector: 'node[type = "start"], node[type = "end"]',
            style: { 'shape': 'ellipse', 'width': '120px', 'height': '44px' }
        },
        {
            selector: 'edge',
            style: {
                'width':              '2px',
                'line-color':         '#666',
                'target-arrow-color': '#666',
                'target-arrow-shape': 'triangle',
                'curve-style':        'bezier',
                'label':              'data(label)',
                'font-size':          '11px',
                'color':              '#333',
                'text-background-color':   '#fff',
                'text-background-opacity': 1,
                'text-background-padding': '2px'
            }
        },
        {
            selector: ':selected',
            style: { 'border-color': '#ff0', 'border-width': '3px' }
        }
    ];
    
    var styleSewing = [
        {
            selector: 'node[role = "number"]',
            style: {
                'label':            'data(label)',
                'text-valign':      'center',
                'text-halign':      'center',
                'color':            '#000',
                'font-size':        '14px',
                'font-weight':      'bold',
                'width':            '32px',
                'height':           '32px',
                'shape':            'rectangle',
                'background-color': '#ffc107',
                'border-width':     '0px'
            }
        },
        {
            selector: 'node[role = "label"]',
            style: {
                'label':            'data(label)',
                'text-valign':      'center',
                'text-halign':      'center',
                'color':            '#fff',
                'font-size':        '11px',
                'font-weight':      '500',
                'text-wrap':        'wrap',
                'text-max-width':   '130px',
                'width':            '150px',
                'height':           'label',
                'padding':          '10px',
                'shape':            'roundrectangle',
                'background-color':  'data(color)',
                'border-width':     '0px'
            }
        },

        // Loại 1: số → số (dọc, đỏ đậm)
        {
            selector: 'edge[etype = "vertical"]',
            style: {
                'width':              '2.5px',
                'line-color':         '#dc3545',
                'target-arrow-color': '#dc3545',
                'target-arrow-shape': 'triangle',
                'source-arrow-shape': 'none',
                'curve-style':        'bezier',
                'control-point-step-size':10,
                'label':              ''
            }
        },

        // Loại 2: số → label (ngang, vang hơn)
        {
            selector: 'edge[etype = "horizontal"]',
            style: {
                'width':              '6px',
                'line-color':         '#ffc107',
                'target-arrow-color': '#ffc107',
                'target-arrow-shape': 'triangle',
                'source-arrow-shape': 'none',
                'curve-style':        'straight',
                'label':              ''
            }
        },

        { selector: ':selected', style: { 'border-color': '#ff0', 'border-width': '3px' } }
    ];


    function getActiveTab() {
        return $('#processTabs .nav-link.active').attr('href');
    }

    function getActiveCy() {
        var tab = getActiveTab();
        return cyInstances[typeMap[tab].id];
    }

    function getActiveType() {
        return typeMap[getActiveTab()].type;
    }

    function initCytoscape(containerId, elements, isSewing) {
        if (cyInstances[containerId]) {
            cyInstances[containerId].fit();
            return;
        }
        
        var useStyle = isSewing ? styleSewing : styleDefault;

        var cy = cytoscape({
            container: document.getElementById(containerId),
            elements:  elements,
            style:     useStyle,
            layout:    { name: 'preset', padding: 30 },
            zoom:    0.8,
            minZoom: 0.2,
            maxZoom: 3
        });
        
        // Edge handles
        var eh = cy.edgehandles({
            canConnect: function(sourceNode, targetNode) {
                return sourceNode.id() !== targetNode.id();
            },
            edgeParams: function(sourceNode, targetNode) {
                // Tự detect etype
                var etype = 'vertical';
                if (isSewing) {
                    var srcRole = sourceNode.data('role');
                    var tgtRole = targetNode.data('role');
                    if ((srcRole === 'number' && tgtRole === 'label') || (srcRole === 'label' && tgtRole === 'number')) {
                        etype = 'horizontal';
                    }
                }
                return {
                    data: { etype: etype }
                };
            },
            hoverDelay: 150,
            snap: false,
            handleNodes: 'node',
            loopAllowed: function() {
                return false;
            }
        });
        
        // Lưu eh vào instance để dùng toggle
        cy.ehInstance = eh;
        eh.disable(); // mặc định tắt
        
        // Sau khi kéo tạo edge → lưu DB    
        cy.on('ehcomplete', function(event, sourceNode, targetNode, addedEdge) {
            var etype = addedEdge.data('etype') || 'vertical';

            // Insert vào database
            $.ajax({
                url: baseUrl + 'process/add-edge',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    process_type: isSewing ? 'sewing' : getActiveType(),
                    source:       sourceNode.id(),
                    target:       targetNode.id(),
                    label:        '',
                    etype:        etype
                }),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    // Update edge id và db_id
                    addedEdge.data('id',    'e_' + res.id);
                    addedEdge.data('db_id', res.id);
                    addedEdge.data('etype', etype);
                },
                error: function() {
                    // Nếu lỗi thì xóa edge vừa tạo
                    cy.remove(addedEdge);
                    alert('Lỗi khi tạo edge!');
                }
            });
        });

        // Kéo thả → lưu vị trí
        cy.on('dragfree', 'node', function(e) {
            var node   = e.target;
            var dbId   = node.data('db_id');
            var pos    = node.position();
            
            if (!dbId) return;
            
            var data = {
                x: Math.round(pos.x),
                y: Math.round(pos.y)
            };
            
            // nếu là node number
            if(node.data('role') === 'number'){
                data.type = 'number';
            }else{
                data.type = 'label';
            }

            $.ajax({
                url: baseUrl + 'process/save-position/' + dbId,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
        });

        // Double click → edit node
        cy.on('dblclick', 'node', function(e) {
            var node = e.target;
            selectedNode = node;
            openEditModal(node);
        });

        // Right click node → context menu
        cy.on('cxttap', 'node', function(e) {
            selectedNode = e.target;
            selectedEdge = null;
            showContextMenu(e.originalEvent);
        });

        // Right click edge → context menu
        cy.on('cxttap', 'edge', function(e) {
            selectedEdge = e.target;
            selectedNode = null;
            showContextMenu(e.originalEvent);
        });

        // Click vào nền → ẩn context menu
        cy.on('tap', function(e) {
            if (e.target === cy) {
                hideContextMenu();
            }
        });

        cyInstances[containerId] = cy;
    }

    // ===================== EDGE HANDLE TOGGLE =====================
    $('#btn-edgehandle').on('click', function() {
        edgeHandleOn = !edgeHandleOn;
        var cy = getActiveCy();
        if (!cy || !cy.ehInstance) return;

        if (edgeHandleOn) {
            cy.ehInstance.enable();
            cy.ehInstance.enableDrawMode();
            $(this).removeClass('btn-outline-warning').addClass('btn-warning');
            $(this).html('<i class="fas fa-bezier-curve"></i> Edge Handle ON');
        } else {
            cy.ehInstance.disableDrawMode();
            cy.ehInstance.disable();
            $(this).removeClass('btn-warning').addClass('btn-outline-warning');
            $(this).html('<i class="fas fa-bezier-curve"></i> Edge Handle');
        }
    });

    // Mở modal edit
    function openEditModal(node) {
        $('#modal-node-title').html('<i class="fas fa-edit"></i> Edit Node');
        $('#node-db-id').val(node.data('db_id'));
        $('#node-cy-id').val(node.id());
        $('#node-type').val(node.data('type'));
        
        if(node.data('role') === 'number') {
            var cy = getActiveCy();
            var numLabel = node.data('label');
            
            var labelNodeId = node.id().replace('_num', '');
            var labelNode = cy.getElementById(labelNodeId);
            
            $('#node-number').val(numLabel);
            $('#node-label').val(labelNode.length ? labelNode.data('label'): '');
            selectedColor = labelNode.length ? labelNode.data('color') : '#5b9bd5';
        } else {
            $('#node-number').val(node.data('number') || '');
            $('#node-label').val(node.data('label'));
            selectedColor = node.data('color') || '#007bff';
        }
        
        updateColorSelection(selectedColor);
        $('#modal-node').modal('show');
    }

    // Mở modal add node
    $('#btn-add-node').on('click', function() {
        selectedNode = null;
        $('#modal-node-title').html('<i class="fas fa-plus"></i> Add Node');
        $('#node-db-id').val('');
        $('#node-cy-id').val('');
        $('#node-number').val('');
        $('#node-label').val('');
        $('#node-type').val('process');
        $('#node-pos-x').val(200);
        $('#node-pos-y').val(200);
        selectedColor = '#007bff';
        updateColorSelection(selectedColor);
        
        // Tìm vị trí trống không đè lên node nào
        var pos = findEmptyPosition();
        $('#node-pos-x').val(pos.x);
        $('#node-pos-y').val(pos.y);
        
        $('#modal-node').modal('show');
    });
    
    function findEmptyPosition() {
        var cy       = getActiveCy();
        var nodeW    = 160;  // width node
        var nodeH    = 60;   // height node
        var padding  = 20;   // khoảng cách tối thiểu
        var startX   = 100;
        var startY   = 100;
        var stepX    = nodeW + padding;
        var stepY    = nodeH + padding;
        var maxCols  = 5;

        // Lấy tất cả vị trí node hiện tại
        var occupied = [];
        if (cy) {
            cy.nodes().forEach(function(n) {
                var p = n.position();
                occupied.push({ x: p.x, y: p.y });
            });
        }

        // Tìm vị trí trống
        function isOverlap(x, y) {
            for (var i = 0; i < occupied.length; i++) {
                var o = occupied[i];
                if (Math.abs(o.x - x) < nodeW + padding &&
                    Math.abs(o.y - y) < nodeH + padding) {
                    return true;
                }
            }
            return false;
        }

        var col = 0;
        var row = 0;
        var found = false;
        var maxTries = 100;
        var tries = 0;

        while (!found && tries < maxTries) {
            var x = startX + col * stepX;
            var y = startY + row * stepY;

            if (!isOverlap(x, y)) {
                return { x: x, y: y };
            }

            col++;
            if (col >= maxCols) {
                col = 0;
                row++;
            }
            tries++;
        }

        // Fallback — đặt dưới node cuối cùng
        var maxY = 100;
        if (cy) {
            cy.nodes().forEach(function(n) {
                if (n.position().y > maxY) maxY = n.position().y;
            });
        }
        return { x: startX, y: maxY + nodeH + padding };
    }

    // Chọn màu
    $(document).on('click', '.color-option', function() {
        selectedColor = $(this).data('color');
        $('#node-color').val(selectedColor);
        updateColorSelection(selectedColor);
    });

    function updateColorSelection(color) {
        $('.color-option').css('border-color', 'transparent');
        $('.color-option[data-color="' + color + '"]').css('border-color', '#333');
        $('#node-color').val(color);
    }

    // Lưu node
    $('#btn-save-node').on('click', function() {
        var number = $('#node-number').val().trim();
        var label   = $('#node-label').val().trim();
        var type    = $('#node-type').val();
        var color   = $('#node-color').val() || selectedColor;
        var dbId    = $('#node-db-id').val();
        var cyId    = $('#node-cy-id').val();
        var posX    = parseInt($('#node-pos-x').val()) || 200;
        var posY    = parseInt($('#node-pos-y').val()) || 200;
        var numberX    = parseInt($('#node-number-x').val()) || 200;
        var numberY    = parseInt($('#node-number-y').val()) || 200;

        if (!label) { alert('Nhập label!'); return; }

        var cy = getActiveCy();

        if (dbId) {
            // Update existing
            $.ajax({
                url: baseUrl + 'process/update-node/' + dbId,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    label: label, 
                    node_type: type, 
                    color: color,
                    number: number,
                    position_x: Math.round(cy.getElementById(cyId).position().x),
                    position_y: Math.round(cy.getElementById(cyId).position().y),
                    number_x: Math.round(cy.getElementById(cyId).position().x),
                    number_y: Math.round(cy.getElementById(cyId).position().y)
                }),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function() {
                    var node = cy.getElementById(cyId);
                    node.data('number', number);    
                    node.data('label', label);
                    node.data('type', type);
                    node.data('color', color);
                    
                     // Nếu là node number → update label của số
                    if (node.data('role') === 'number') {
                        node.data('label', number);
                        var labelNodeId = cyId.replace('_num', '');
                        
                        var labelNode = cy.getElementById(labelNodeId);
                        if (labelNode.length) {
                            labelNode.data('label', label);
                            labelNode.data('color', color);
                            labelNode.style('background-color', color);
                        }
                    } else {
                        // Update màu trực tiếp
                        node.style('background-color', color);
                        // Nếu có node number → update label số
                        var numNode = cy.getElementById(cyId + '_num');
                        if (numNode.length) {
                            numNode.data('label', number);
                        }
                    }
                    
                    cy.style().update();
                    $('#modal-node').modal('hide');
                }
            });
        } else {
            // Add new
            var newId = 'node_' + Date.now();
            $.ajax({
                url: baseUrl + 'process/add-node',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    process_type: getActiveType(),
                    node_id:      newId,
                    number:       number,
                    label:        label,
                    node_type:    type,
                    color:        color,
                    position_x:   posX,
                    position_y:   posY,
                    number_x:     numberX,
                    number_y:     numberY
                }),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    cy.add({
                        data: { 
                            id: newId,
                            db_id: res.id,
                            number: number,
                            label: label,
                            type: type,
                            color: color,
                            role: 'label'
                        },
                        position: { x: posX, y: posY }
                    });

                    // nếu là sewing → tạo node number
                    if(getActiveType() === 'sewing' && number){
                        var numId = newId + '_num'; 
                        
                        cy.add([
                            {
                                data:{
                                    id: numId,
                                    label: number,
                                    role:'number',
                                    db_id: res.id
                                },
                                position:{
                                    x: posX - 90,
                                    y: posY
                                }
                            }
                        ]);
                        
                        $.ajax({
                            url: baseUrl + 'process/add-edge',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                process_type: 'sewing',
                                source:       numId,
                                target:       newId,
                                label:        '',
                                etype:        'horizontal'
                            }),
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            success: function(edgeRes) {
                                // Thêm edge vào cytoscape với db_id
                                cy.add({
                                    data: {
                                        id:     'e_' + edgeRes.id,
                                        db_id:  edgeRes.id,
                                        source: numId,
                                        target: newId,
                                        etype:  'horizontal'
                                    }
                                });
                            }
                        });
                    }

                    $('#modal-node').modal('hide');
                }
            });
        }
    });

    // Add edge
    $('#btn-add-edge').on('click', function() {
        var cy    = getActiveCy();
        var nodes = cy.nodes();
        var opts  = '';
        nodes.forEach(function(n) {
            opts += '<option value="' + n.id() + '">' + n.data('label').replace(/\n/g, ' ') + '</option>';
        });
        $('#edge-source').html(opts);
        $('#edge-target').html(opts);
        $('#edge-label').val('');
        $('#modal-edge').modal('show');
    });

    $('#btn-save-edge').on('click', function() {
        var source = $('#edge-source').val();
        var target = $('#edge-target').val();
        var label  = $('#edge-label').val();
        var cy = getActiveCy();

        if (source === target) { alert('Source và Target không được giống nhau!'); return; }

        $.ajax({
            url: baseUrl + 'process/add-edge',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                process_type: getActiveType(),
                source: source, 
                target: target, 
                label: label,
                etype: 'vertical'
            }),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                cy.add({
                    data: { id: 'e_' + res.id, db_id: res.id, source: source,etype: 'vertical', target: target, label: label }
                });
                $('#modal-edge').modal('hide');
            }
        });
    });

    // Context menu
    function showContextMenu(event) {
        var menu = $('#cy-context-menu');
        menu.css({ top: event.clientY + 'px', left: event.clientX + 'px', display: 'block' });
        event.preventDefault();
    }

    function hideContextMenu() {
        $('#cy-context-menu').hide();
        selectedNode = null;
        selectedEdge = null;
    }

    $('#ctx-edit').on('click', function() {
        var nodeToEdit = selectedNode;
        
        hideContextMenu();
       
        if (nodeToEdit) {
            openEditModal(nodeToEdit);
        }else {
            return;
        };
    });

    $('#ctx-delete').on('click', function() {
        
        var nodeToDelete = selectedNode;
        var edgeToDelete = selectedEdge;
        
        hideContextMenu();
        if (!confirm('Xóa phần tử này?')) return;
        

        var cy = getActiveCy();
        
        if (nodeToDelete) {
            var dbId = nodeToDelete.data('db_id');
            $.ajax({
                url: baseUrl + 'process/delete-node/' + dbId,
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function() {
                    cy.remove(nodeToDelete);
                    selectedNode = null;
                }
            });
        }

        if (edgeToDelete) {
            var edgeDbId = edgeToDelete.data('db_id');
            $.ajax({
                url: baseUrl + 'process/delete-edge/' + edgeDbId,
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function() {
                    cy.remove(edgeToDelete);
                    selectedEdge = null;
                }
            });
        }
    });

    // Ẩn context menu khi click ra ngoài
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#cy-context-menu').length) {
            hideContextMenu();
        }
    });

    // Init tab đầu tiên
    initCytoscape('cy-sewing', elementsSewing, true);

    // Chuyển tab
    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
        var href = $(e.target).attr('href');
        var isSewing = href === '#tab-sewing';
        var info = typeMap[href];
        if (info) initCytoscape(info.id, info.els, isSewing);
    });

    // Fit
    $('#btn-fit').on('click', function() {
        var cy = getActiveCy();
        if (cy) cy.fit();
    });

    // Print
    $('#btn-print').on('click', function() {
        var cy = getActiveCy();
        if (!cy) return;
        var imgData = cy.png({ full: true, scale: 2, bg: '#fff' });
        var win = window.open('', '_blank');
        win.document.write('<html><body style="margin:0;"><img src="' + imgData + '" style="width:100%;"></body></html>');
        win.document.close();
        win.onload = function() { win.print(); };
    });

});