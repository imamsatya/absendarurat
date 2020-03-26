<template>
    <v-app id="inspire">
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <v-toolbar color="primary" dark flat>
                                <v-toolbar-title>Import Absen</v-toolbar-title>
                                <v-spacer />
                                <!-- <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn :href="source" icon large target="_blank" v-on="on">
                                            <v-icon>mdi-code-tags</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Source</span>
                                </v-tooltip>
                                <v-tooltip right>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon large href="https://codepen.io/johnjleider/pen/pMvGQO"
                                            target="_blank" v-on="on">
                                            <v-icon>mdi-codepen</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Codepen</span>
                                </v-tooltip> -->
                            </v-toolbar>
                            <v-card-text>
                                <!-- <v-form >
                                    <input  label="Regular" type="file" v-on:change="onFileChange">
                                    <v-text-field label="Regular" type="file" v-on:change="onImageChange"></v-text-field>
                                    <q-input @input="val => { file = val[0] }" filled type="file" hint="File Scan" @change="uploadFile" />
                                </v-form> -->

                                <form @submit="formSubmit" enctype="multipart/form-data">

                                    <!-- <strong>Name:</strong>

                        <input type="text" class="form-control" v-model="name"> -->

                                    <strong>File:</strong>

                                    <input type="file" class="form-control" v-on:change="onFileChange">



                                    <!-- <button class="btn btn-success">Submit</button> -->
                                     <v-card-actions>
                                <v-spacer />
                                <v-btn color="primary" @click="formSubmit">Proses</v-btn>
                            </v-card-actions>
                                </form>
                            </v-card-text>
                           
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
          <v-footer class="indigo justify-center pl-0" padless inset app>
            <v-card flat tile class="indigo  white--text text-center">
                <v-card-text class="white--text">
                    <p>Luaskan ilmu, luaskan manfaat <br>

                        [ ] dengan <span class="red--text"> ❤ </span>
                        <!-- <q-spinner-hearts class="animated 2s infinite fadeIn" color="red" size="2.5em" /> -->
                        di Palu</p>
                    ©2020 — Imam Satya Wedhatama 


                    <!-- {{ new Date().getFullYear() }} — <strong>Vuetify</strong> -->
                </v-card-text>
            </v-card>
        </v-footer>
    </v-app>

    <!-- <div class="container">
        <div class="large-12 medium-12 small-12 filezone">
            <input type="file" id="files" ref="files" multiple v-on:change="handleFiles()"/>
            <p>
                Drop your files here <br>or click to search
            </p>
        </div>

        <div v-for="(file, key) in files" class="file-listing" :key="file">
            <img class="preview" v-bind:ref="'preview'+parseInt(key)"/>
            {{ file.name }}
            <div class="success-container" v-if="file.id > 0">
                Success
            </div>
            <div class="remove-container" v-else>
                <a class="remove" v-on:click="removeFile(key)">Remove</a>
            </div>
        </div>

        <a class="submit-button" v-on:click="submitFiles()" v-show="files.length > 0">Submit</a>
    </div> -->

</template>

<script>
    export default {
        props: {
            source: String,
        },
        data() {
            return {
                file_data: [],
                files: [],
                image: '',

                name: '',

                file: '',

                success: ''
            }
        },
        methods: {
            onFileChange(e) {

                console.log(e.target.files[0]);

                this.file = e.target.files[0];

            },

           async formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                const configx = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        // 'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
                        //  Authorization: 'Bearer ' + localStorage.getItem('token')
                    }

                }
                let formData = new FormData();

                formData.append('file', this.file);

                // let data = new FormData(); 
                // data.append('file', this.avatar);
                // data.append('_method', 'put'); // add this
                // formData.append('_method', 'put'); 


                console.log('formData', formData)
               await axios.post('/proses', formData, configx)
                    // axios.post('/proses', {formData: this.file})

                    // .then(function (response) {
                    //     console.log('success')
                    //     currentObj.success = response.data.success;

                    // })

                    // .catch(function (error) {
                    //     console.log(error)
                    //     currentObj.output = error;

                    // });

                    .then(response => {
                        console.log(response)
                    }).catch(error => {
                        console.log(error.response)
                    })
                    .then(
               window.location.href = "/download_excel/"
                )

            }

        }
    }

</script>
