let DataTable = {
    getLanguageFileUrl: function () {
        return "/vendor/adminlte/plugins/datatables-i18n/Turkish.json";
    },
    getUsers: function (ajaxUrl) {
        var user_table = $("#users_data_table").DataTable({
            "oLanguage": {
                "sUrl": this.getLanguageFileUrl()
            },
            responsive: true,
            bAutoWidth: false,
            "dom": 'frtip',
            "pageLength": 30,
            "searchDelay": 1500,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": ajaxUrl,
                data: function (d) {
                },
                dataSrc: function (json) {
                    if (!json.recordsTotal) {
                        return false;
                    }
                    return json.data;
                }
            },
            "order": [],
            "columns": [
                {"data": "name", "orderable": true,},
                {"data": "email", "orderable": true},
                {"data": "village.name","name":"village.name", "orderable": true},
                {"data": "status", "orderable": true, "searchable": false},
                {"data": "roles", "orderable": false, "searchable": false},
                {"data": "permissions", "orderable": false, "searchable": false},
                {"data": "action", "orderable": false, "searchable": false},
            ],
            "initComplete": function (settings, json) {
            }
        });
    },
    getPermissions: function (ajaxUrl) {
        var user_table = $("#permissions_data_table").DataTable({
            "oLanguage": {
                "sUrl": this.getLanguageFileUrl()
            },
            responsive: true,
            bAutoWidth: false,
            "dom": 'frtip',
            "pageLength": 30,
            "searchDelay": 1500,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": ajaxUrl,
                data: function (d) {
                },
                dataSrc: function (json) {
                    if (!json.recordsTotal) {
                        return false;
                    }
                    return json.data;
                }
            },
            "order": [],
            "columns": [
                {"data": "id", "orderable": true,},
                {"data": "name", "orderable": true},
                {"data": "action", "orderable": false, "searchable": false},
            ],
            "initComplete": function (settings, json) {
            }
        });
    },
    getRoles: function (ajaxUrl) {
        var role_table = $("#roles_data_table").DataTable({
            "oLanguage": {
                "sUrl": this.getLanguageFileUrl()
            },
            responsive: true,
            bAutoWidth: false,
            "dom": 'frtip',
            "pageLength": 30,
            "searchDelay": 1500,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": ajaxUrl,
                data: function (d) {
                },
                dataSrc: function (json) {
                    if (!json.recordsTotal) {
                        return false;
                    }
                    return json.data;
                }
            },
            "order": [],
            "columns": [
                {"data": "id", "orderable": true,},
                {"data": "name", "orderable": true},
                {"data": "permissions", "orderable": false, "searchable": false},
                {"data": "action", "orderable": false, "searchable": false},
            ],
            "initComplete": function (settings, json) {
            }
        });
    },
    getPatients: function (ajaxUrl) {
        var patients_table = $("#roles_data_table").DataTable({
            "oLanguage": {
                "sUrl": this.getLanguageFileUrl()
            },
            "drawCallback": function( settings ) {
                $('[data-toggle="tooltip"]').tooltip();
            },
            responsive: true,
            bAutoWidth: false,
            "dom": 'frtip',
            "pageLength": 30,
            "searchDelay": 1500,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": ajaxUrl,
                data: function (d) {
                },
                dataSrc: function (json) {
                    if (!json.recordsTotal) {
                        return false;
                    }
                    return json.data;
                }
            },
            "order": [],
            "columns": [
                {"data": "name", "orderable": true,},
                {"data": "tckn", "orderable": false},
                {"data": "age", "orderable": true, "searchable": false},
                {"data": "gsm", "orderable": false, "searchable": true},
                {"data": "village.name", "name": "village.name", "orderable": true, "searchable": true},
                {"data": "positive_or_contacted", "name": "positive_or_contacted", "orderable": true, "searchable": true},
                {"data": "patientStatus.name", "name": "patientStatus.name", "orderable": true, "searchable": true},
                {"data": "dailyChecks.check_date", "name": "dailyChecks.check_date", "orderable": true, "searchable": true},
                {"data": "vaccines.last_vaccines_date", "name": "vaccines.last_vaccines_date", "orderable": true, "searchable": true},
                {"data": "action", "orderable": false, "searchable": false},
            ],
            "initComplete": function (settings, json) {

            }
        });

    },


};
