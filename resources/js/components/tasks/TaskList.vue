<template>
    <div>
        <div class="container">
            <!--@if ($projects->count())-->
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Tasks</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <a href="#addTaskModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add Task</span></a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Project</th>
                        <th>Task</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody  v-for="t in tasks">
                    <tr>
                        <td>{{ t.project.name }}</td>
                        <td style="width: 38%">{{ t.name }}</td>
                        <td>{{ t.description }}</td>
                        <td>
                            <a href="#editTaskModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit" @click="set(t.id)">&#xE254;</i></a>
                            <a href="#delTaskModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete" @click="set(t.id)">&#xE872;</i></a>
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
        <div id="addTaskModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Add Task</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Task Project</label>
                                <select class="form-control" v-model="newTask.project_id">
                                    <option v-for="p in projects" :value="p.id">{{ p.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Task Name</label>
                                <input type="text" class="form-control" v-model="newTask.name" />
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" v-model="newTask.description"></textarea>
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
        <div id="editTaskModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Task</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Task Project</label>
                                <select class="form-control">
                                    <option>select...</option>
                                    <option v-for="p in projects" v-model="newTask.project_id">{{ p.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" v-model="newTask.name" required />
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" class="form-control" v-model="newTask.description"></textarea>
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
        <div id="delTaskModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Task</h4>
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
        name: "task-list",

        data() {
            return {
                projects: [],
                tasks: [],
                taskId: null,
                newTask: {
                    'project_id': null,
                    'name': '',
                    'description': ''
                },
            };
        },
        created() {
            $.getJSON('tasks', function (tasks) {
                this.tasks = tasks
            }.bind(this));
            $.getJSON('projects', function (projects) {
                this.projects = projects;
            }.bind(this));
        },
        methods: {
            set(taskId) {
                this.taskId = taskId;
                this.getTask();
            },
            getTask() {
                let app = this;
                let newTask = app.newTask;

                if (this.taskId !== null) {
                    axios.get('tasks/' + this.taskId)
                        .then(function (resp) {
                            newTask.name = resp.data.name;
                            newTask.description = resp.data.description;
                        }).catch(function (error) {
                        console.error(error);
                        alert('Could not get task');
                    });
                }
            },
            create() {
                let app = this;
                let newTask = app.newTask;

                axios.post('/tasks', newTask)
                    .then(function (resp) {
                        console.log(resp);
                    })
                    .catch(function (err) {
                        console.error(err);
                        alert("Could not create your task");
                    });
            },
            save() {
                axios.patch('tasks/' + this.taskId, this.newTask)
                    .then(function (resp) {
                    })
                    .catch(function (err) {
                        console.log('Error ' + err);
                        alert("Could not update task");
                    });
            },
            del() {
                axios.delete('tasks/' + this.taskId)
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