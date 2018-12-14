<template>
    <div>
    <div class="container">
        <!--@if ($clients->count())-->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Clients</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addClientModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Client</span></a>
                        <a href="#deleteClientModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>
                        <span class="custom-checkbox">
                            <input type="checkbox" id="selectAll" @click="checkAllBoxes" />
                            <label for="selectAll"></label>
                        </span>
                    </th>
                    <th>Name</th>
                    <th>Company</th>
                    <th># Projects</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody  v-for="c in clients">
                <tr>
                    <td>
                        <span class="custom-checkbox">
                            <input type="checkbox" id="checkbox1" name="options[]" value="1" />
                            <label for="checkbox1"></label>
                        </span>
                    </td>
                    <td>{{ c.name }}</td>
                    <td>{{ c.company }}</td>
                    <td>{{ c.projects.length }}</td>
                    <!--<td><a :href="'/projects/' + c.projects[0].id">{{ c.projects[0].name }}</a></td>-->
                    <td style="width: 25%">
                        <a href="#addProjModal" data-toggle="modal"><i title="Add project" data-toggle="tooltip" class="material-icons">&#xE147;</i></a>
                        <a href="#editClientModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit" @click="set(c.id)">&#xE254;</i></a>
                        <a href="#deleteClientModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete" @click="set(c.id)">&#xE872;</i></a>
                    </td>
                </tr>
                <!--@endforeach-->
                </tbody>
            </table>

            <div class="clearfix">
                <ul class="pagination">
                    <!--{{ client.render() }}-->
                </ul>
            </div>
        </div>
        <!--@else-->
        <!--<p>No Clients</p>-->
       <!-- @endif-->
    </div>
    <!-- Edit Modal HTML -->
    <div id="addClientModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Add Client</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" v-model="newClient.name" />
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" class="form-control" v-model="newClient.company" />
                        </div>
                        <div class="form-group">
                            <label>Project</label>
                            <input type="text" class="form-control" v-model="newClient.project" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" v-model="newClient.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success" value="Add" @click="create" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <div id="editClientModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Client</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" v-model="newClient.name" required />
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" class="form-control" v-model="newClient.company" />
                        </div>
                        <div class="form-group">
                            <label>Project</label>
                            <input type="text" class="form-control" v-model="newClient.project" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea type="text" class="form-control" v-model="newClient.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                        <input type="submit" class="btn btn-info" value="Save" @click="save" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div id="deleteClientModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Client</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete these Records?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-danger" value="Delete" @click="del" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "client-list",

        data() {
            return {
                clients: [],
                clientId: null,
                newClient: {
                    'name': '',
                    'company': '',
                    'project': '',
                    'description': ''
                },
            };
        },
        created() {
            $.getJSON('clients', function (clients) {
                this.clients = clients
            }.bind(this));
        },
        methods: {
            set(clientId) {
                this.clientId = clientId;
                this.getClient();
            },
            getClient() {
                let app = this;
                let newClient = app.newClient;

                if (this.clientId !== null) {
                    axios.get('clients/' + this.clientId)
                        .then(function (resp) {
                            console.info(resp.data);
                            newClient.name = resp.data.name;
                            newClient.company = resp.data.company;
                            newClient.project = resp.data.projects[0].name;
                            newClient.description = resp.data.description
                        }).catch(function (error) {
                        console.error(error);
                        alert('Could not get client');
                    });
                }
            },
            create() {
                let app = this;
                let newClient = app.newClient;

                axios.post('/clients', newClient)
                    .then(function (resp) {
                        console.log(resp);
                    })
                    .catch(function (err) {
                        console.error(err);
                        alert("Could not create your client");
                    });
            },
            save() {
                axios.patch('clients/' + this.clientId, this.newClient)
                    .then(function (resp) {
                        console.log('data' + resp);
                    })
                    .catch(function (err) {
                        console.log('Error ' + err);
                        alert("Could not update client");
                    });
            },
            del() {
                axios.delete('clients/' + this.clientId)
                    .then(function (resp) {
                        console.log(resp);
                    }).catch(function (resp) {
                        console.log(resp);
                    });
            },

            checkAllBoxes() {
                // Activate tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // Select/Deselect checkboxes
                var checkbox = $('table tbody input[type="checkbox"]');
                $("#selectAll").click(function () {
                    if (this.checked) {
                        checkbox.each(function () {
                            this.checked = true;
                        });
                    } else {
                        checkbox.each(function () {
                            this.checked = false;
                        });
                    }
                    console.log(checkbox);
                });
                checkbox.click(function () {
                    if (!this.checked) {
                        $("#selectAll").prop("checked", false);
                    }
                    //console.log(checkbox);
                });
            }
        }
    }

</script>

<style scoped>

</style>