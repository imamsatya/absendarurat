<template>
    <v-app id="inspire">
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <v-toolbar color="primary" dark flat>
                               
                                <v-toolbar-title> <v-icon>mdi-file-import-outline</v-icon> <span> Import Absen</span></v-toolbar-title>
                                <v-spacer />
                                <!-- <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn :href="source" icon large target="_blank" v-on="on">
                                            <v-icon>mdi-code-tags</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Source</span>
                                </v-tooltip> -->
                                <v-tooltip right>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon 
                                            target="_blank" v-on="on" @click="dialogPanduan">
                                            <v-icon>mdi-help-circle</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Panduan</span>
                                </v-tooltip>
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

                        [ ] dengan <span class="red--text animated infinite fadeIn "> ❤ </span>
                        <!-- <q-spinner-hearts class="animated 2s infinite fadeIn" color="red" size="2.5em" /> -->
                        di Palu</p>
                    ©2020 — Imam Satya Wedhatama 


                    <!-- {{ new Date().getFullYear() }} — <strong>Vuetify</strong> -->
                </v-card-text>
            </v-card>
        </v-footer>

        <!-- dialog -->
        <div class="text-center">
    <v-dialog
      v-model="dialog_panduan"
      width="500"
    >

      <v-card>
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
          Panduan
        </v-card-title>

        <v-card-text>
            Halo - halo semuanya, semoga tetap sehat seperti para atlet yang siap untuk berlaga.Berikut cara penggunaannya : <br><br>

          1. Input File adalah File berformat CSV yang diperoleh dari aplikasi Kaizala <br>
          2. Pastikan Kolom A adalah "Responder Name" dan Kolom F adalah "ResponseTime (UTC)". Kalau bukan? ya dibuat begitu aja :D
          <br><br>

          Jaga kesehatan selalu ya teman - teman, semoga aplikasinya bermanfaat :)

        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="dialog_panduan = false"
          >
            OKE
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
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

                success: '',
                dialog_panduan: false,
            }
        },
        methods: {
            dialogPanduan(){
                this.dialog_panduan = true;
            },
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
               await axios.post('proses', formData, configx)
                    .then(response => {
                        console.log(response)
                    }).catch(error => {
                        console.log('error', error.response)
                    })
                   
               window.location.href = "/download_excel"
                

            }

        }
    }

</script>
