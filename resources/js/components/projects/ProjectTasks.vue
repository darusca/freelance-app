<template>
    <div>
        <div class="container">
            <!--@if ($projects->count())-->
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Project Tasks</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <a href="#addProjModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add Task</span></a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Project</th>
                        <th>Task</th>
                        <th>Description</th>
                        <th>Stopwatch</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody  v-for="p in projects" v-on:click="startTimer()">
                    <tr>
                        <td>{{ p.name }}</td>
                        <td style="width: 38%">{{ p.tasks[0].name }}</td>
                        <td>{{ p.tasks[0].description }}</td>
                        <td><span v-bind:id=setMinId(p.tasks[0].id)>00</span>:<span v-bind:id=setSecId(p.tasks[0].id)>00</span></td>
                        <td style="width: 16%">
                            <!--<component project-tasks="{{ route('project.tasks') }}"><i title="Tasks" data-toggle="tooltip" class="material-icons">&#xE8EE;</i></component>-->
                            <a href="#">
                                <i title="Start timer" data-toggle="tooltip" class="material-icons" @click="startTimer(p.tasks[0].id)">
                                    <span v-if="!timerOn">&#xE425;</span><span v-if="timerOn">&#xE426;</span>
                                </i>
                            </a>
                            <a href="#editProjModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit" @click="set(p.id)">&#xE254;</i></a>
                            <a href="#delProjModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete" @click="set(p.id)">&#xE872;</i></a>
                        </td>
                    </tr>
                    <!--@endforeach-->
                    </tbody>
                </table>

                <div class="clearfix">
                    <ul class="pagination">
                        <!--{{ project.render() }}-->
                    </ul>
                </div>
            </div>
            <!--@else-->
            <!--<p>No Projects</p>-->
            <!-- @endif-->
        </div>
        <!-- Add Modal HTML -->
        <div id="addProjModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Add Project</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Project client</label>
                                <select class="form-control" v-model="newProj.client_id">
                                    <option v-for="c in clients" :value="c.id">{{ c.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Project Name</label>
                                <input type="text" class="form-control" v-model="newProj.name" />
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" v-model="newProj.description"></textarea>
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
        <div id="editProjModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Project</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Project client</label>
                                <select class="form-control" v-model="newProj.client_id">
                                    <option v-for="c in clients" :value="c.id">{{ c.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" v-model="newProj.name" required />
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" class="form-control" v-model="newProj.description"></textarea>
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
        <div id="delProjModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Project</h4>
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
        name: "project-tasks",

        data() {
            return {
                timerOn: false,
                clients: [],
                projects: [],
                projId: null,
                newProj: {
                    'client_id': null,
                    'name': '',
                    'description': ''
                },
            };
        },
        created() {
            $.getJSON('/projects', function (projects) {
                this.projects = projects;
                console.log(projects);
            }.bind(this));
            /*$.getJSON('clients', function (clients) {
                this.clients = clients;
            }.bind(this));*/
        },
        methods: {
            setMinId(task) {
                return 'minutes'+task;
            },

            setSecId(task) {
                return 'seconds'+task;
            },

            //@TODO Extract to a component
            startTimer(task) {
                let sec = 0;

                this.timerOn = true;

                let myInterval = setInterval( function() {
                    $('#'+this.setSecId(task)).html(this.pad(++sec%60));
                    $('#'+this.setMinId(task)).html(this.pad(parseInt(sec/60,10)));
                }.bind(this), 1000);

                function myStopFunction() {
                    clearInterval(myInterval);
                }
            },

            pad(val) {
                return val > 9 ? val : "0" + val;
            },

            set(projId) {
                this.projId = projId;
                this.getProject();
            },
            getProject() {
                let app = this;
                let newProj = app.newProj;

                if (this.projId !== null) {
                    axios.get('projects/' + this.projId)
                        .then(function (resp) {
                            newProj.name = resp.data.name;
                            newProj.description = resp.data.description;
                        }).catch(function (error) {
                        console.error(error);
                        alert('Could not get project');
                    });
                }
            },
            create() {
                let app = this;
                let newProj = app.newProj;

                axios.post('/projects', newProj)
                    .then(function (resp) {
                        console.log(resp);
                    })
                    .catch(function (err) {
                        console.error(err);
                        alert("Could not create your project");
                    });
            },
            save() {
                axios.patch('projects/' + this.projId, this.newProj)
                    .then(function (resp) {
                    })
                    .catch(function (err) {
                        console.log('Error ' + err);
                        alert("Could not update project");
                    });
            },
            del() {
                axios.delete('projects/' + this.projId)
                    .then(function (resp) {
                        console.log(resp);
                    }).catch(function (resp) {
                    console.log(resp);
                });
            }
        }
    }

</script>

<style scoped>

</style>