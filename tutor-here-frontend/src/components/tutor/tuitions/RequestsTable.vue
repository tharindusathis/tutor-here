<template>
  <b-row>
    <b-col sm="12">
      <b-card v-show="items.length > 0">
        <b-container fluid>

          <!-- User Interface controls -->
          <b-row>
            <b-col md="6" class="my-1">
              <b-form-group label-cols-sm="3" label="Filter" class="mb-0">
                <b-input-group>
                  <b-form-input v-model="filter" placeholder="Type to Search"/>
                  <b-input-group-append>
                    <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                  </b-input-group-append>
                </b-input-group>
              </b-form-group>
            </b-col>
            <b-col md="6" class="my-1">
              <b-form-group label-cols-sm="3" label="Sort" class="mb-0">
                <b-input-group>
                  <b-form-select v-model="sortBy" :options="sortOptions">
                    <option slot="first" :value="null">-- none --</option>
                  </b-form-select>
                  <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                    <option :value="false">Asc</option>
                    <option :value="true">Desc</option>
                  </b-form-select>
                </b-input-group>
              </b-form-group>
            </b-col>

            <b-col md="6" class="my-1">
              <b-form-group label-cols-sm="3" label="Sort direction" class="mb-0">
                <b-input-group>
                  <b-form-select v-model="sortDirection" slot="append">
                    <option value="asc">Asc</option>
                    <option value="desc">Desc</option>
                    <option value="last">Last</option>
                  </b-form-select>
                </b-input-group>
              </b-form-group>
            </b-col>

            <b-col md="6" class="my-1">
              <b-form-group label-cols-sm="3" label="Per page" class="mb-0">
                <b-form-select :options="pageOptions" v-model="perPage"/>
              </b-form-group>
            </b-col>
          </b-row>

          <!-- Main table element -->
          <b-row>
            <b-col>

              <b-table
                  show-empty
                  stacked="md"
                  :items="items"
                  :busy.sync="isBusy"
                  :fields="fields"
                  :current-page="currentPage"
                  :per-page="perPage"
                  :filter="filter"
                  :sort-by.sync="sortBy"
                  :sort-desc.sync="sortDesc"
                  :sort-direction="sortDirection"
                  :hover="true"
                  @filtered="onFiltered"
                  :tbody-tr-class="rowColor"
              >
                <div slot="table-busy" class="text-center text-danger my-2">
                  <b-spinner class="align-middle"/>
                  <strong> Loading...</strong>
                </div>

                <!-- <template slot="name" slot-scope="row">
                  {{ row.value.first }} {{ row.value.last }}
                </template>

                <template slot="isActive" slot-scope="row">
                  {{ row.value ? 'Yes :)' : 'No :(' }}
                </template> -->

                <template slot="created_at" slot-scope="row">
                  <!-- `data.value` is the value after formatted by the Formatter -->
                  <a :href="`tuition/${ parseInt(row.item.idRequest) }`"> {{ row.item.created_at }} </a>
                </template>

                <template slot="actions" slot-scope="row">
                  <b-button v-if="(row.item.status == 0)"
                            variant="success" size="sm" @click="requestAcceptView(row.item, row.index, $event.target)"
                            class="mr-1">
                    ACCEPT
                  </b-button>
                  <b-button v-if="(row.item.status == 0)"
                            variant="danger" size="sm"
                            @click="requestDeclineView(row.item, row.index, $event.target)"
                            class="mr-1">
                    DECLINE
                  </b-button>
                  <router-link :to="`dashboard_tutor/tuition/${ parseInt(row.item.idRequest) }`">
                    <b-button v-if="(row.item.status == 1)"
                              variant="warning" size="sm"
                              class="mr-1">
                      START TUITION
                    </b-button>
                  </router-link>

                  <!--<b-button size="sm" @click="row.toggleDetails">-->
                  <!--{{ row.detailsShowing ? 'Hide' : 'Show' }} Details-->
                  <!--</b-button>-->
                </template>

                <template slot="row-details" slot-scope="row">
                  <b-card>
                    <ul>
                      <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
                    </ul>
                  </b-card>
                </template>
              </b-table>
            </b-col>
          </b-row>
          <b-row>
            <b-col md="6" class="my-1">
              <b-pagination
                  :total-rows="totalRows"
                  :per-page="perPage"
                  v-model="currentPage"
                  class="my-0"
              />
            </b-col>
          </b-row>

          <!-- Info modal -->
          <!--<b-modal id="modalInfoAccept" @hide="resetModal" :title="modalInfoAccept.title" hide-footer>-->
          <!--<template v-if="modalInfoAccept.item">-->
          <!--<pre>{{ modalInfoAccept.item.subject_name }}</pre>-->
          <!--</template>-->
          <!--<b-button class="mt-3" variant="outline-success" block @click="hideModal">Confirm Accept</b-button>-->
          <!--<b-button class="mt-2" variant="outline-warning" block @click="toggleModal">Cancel</b-button>-->
          <!--</b-modal>-->

          <!-- Info modal -->
          <!--<b-modal id="modalInfoDecline" @hide="resetModal" :title="modalInfoDecline.title" ok-only>-->
          <!--<template v-if="modalInfoDecline.item">-->
          <!--<pre>{{ modalInfoDecline.item.start_time }}</pre>-->
          <!--<pre>{{ modalInfoDecline.item.end_time }}</pre>-->
          <!--</template>-->
          <!--</b-modal>-->


        </b-container>
      </b-card>
      <b-card v-if="items.length == 0 || items == null" class="align-items-center d-flex justify-content-center">
        <div class="m-5">
          <h4>
            <b-badge variant="dark">EMPTY LIST</b-badge>
          </h4>
          <h6>You do not have any tuition requests or tuition history.</h6>
        </div>

      </b-card>
    </b-col>
  </b-row>
</template>

<script>
  const items = []

  export default {
    name: "RequestsTable",
    props: {
      idTutor: {
        default: 1,
        type: Number
      }
    },
    data() {
      return {
        items: items,
        isBusy: false,
        fields: [
          {key: 'created_at', label: 'Requested On', sortable: true},
          {key: 'idRequest', label: 'ID'},
          {key: 'date', label: 'Date', sortable: true},
          {key: 'start_time', label: 'From', sortable: true},
          {key: 'end_time', label: 'To', sortable: true},
          {key: 'subject_name', label: 'Subject', sortable: true},
          {key: 'grade', label: 'Level', sortable: true},
          {key: 'dist', label: 'KM', sortable: true},
          {key: 'actions', label: 'Actions'},
        ],
        currentPage: 1,
        perPage: 10,
        totalRows: 10,
        pageOptions: [5, 10, 50, 100, 500],
        sortBy: null,
        sortDesc: false,
        sortDirection: 'asc',
        filter: null,
        modalInfo: {title: '', content: ''},
        modalInfoAccept: {title: '', content: '', item: []},
        modalInfoDecline: {title: '', content: '', item: []}
      }
    },
    mounted() {
      this.loadContent();
    },
    computed: {
      // totalRows: function () { return this.items.length },

      sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return {text: f.label, value: f.key}
          })
      }
    },
    methods: {
      loadContent() {
        this.isBusy = true;
        this.$http.get('tutors/' + this.idTutor + '/requests')
          .then(response => {
            console.log(response);

            const items = response.data.all;
            this.items = items;
            this.totalRows = items.length;
            this.isBusy = false;

          }, error => {
            console.log(error);
            this.items = [];
            this.isBusy = false;
          });
      },
      accpetRequest(id) {
        this.isBusy = true;
        this.$http.get('request/accept/' + id)
          .then(response => {
            console.log(response);
            this.isBusy = false;
            this.loadContent();
          }, error => {
            console.log(error);
            this.items = [];
            this.isBusy = false;
          });
      },
      declineRequest(id) {
        this.isBusy = true;
        this.$http.get('request/decline/' + id)
          .then(response => {
            console.log(response);
            this.isBusy = false;
            this.loadContent();
          }, error => {
            console.log(error);
            this.items = [];
            this.isBusy = false;
          });
      },
      // requestAcceptView(item, index, button) {
      //   this.modalInfoAccept.title = "Accept The Tuition Request?";
      //   this.modalInfoAccept.item = item
      //   this.$root.$emit('bv::show::modal', 'modalInfoAccept', button)
      // },
      // requestDeclineView(item, index, button) {
      //   this.modalInfoDecline.title = "Accept The Tuition Request?";
      //   //this.modalInfoDecline.content = JSON.stringify(item, null, 2)
      //   this.modalInfoDecline.item = item
      //   this.$root.$emit('bv::show::modal', 'modalInfoDecline', button)
      // },


      resetModal() {
        this.modalInfo.title = ''
        this.modalInfo.content = ''
      },

      onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },
      requestDeclineView(item, index, button) {
        let content = 'Confirm to Decline Request';
        this.$bvModal.msgBoxConfirm(content, {
          title: 'Declining Request',
          size: 'sm',
          buttonSize: 'sm',
          okVariant: 'danger',
          okTitle: 'Decline',
          cancelTitle: 'Cancel',
          footerClass: 'p-2',
          hideHeaderClose: false,
          centered: true
        })
          .then(value => {
            if (value) {
              this.declineRequest(item.idRequest)
            }
          })
          .catch(err => {
            // An error occurred
          })
      },
      requestAcceptView(item, index, button) {
        let content = 'Confirm to Accept Request';
        this.$bvModal.msgBoxConfirm(content, {
          title: 'Accepting Request',
          size: 'sm',
          buttonSize: 'sm',
          okVariant: 'success',
          okTitle: 'Accept',
          cancelTitle: 'Cancel',
          footerClass: 'p-2',
          hideHeaderClose: false,
          centered: true
        })
          .then(value => {
            if (value) {
              this.accpetRequest(item.idRequest)
            }
          })
          .catch(err => {
            // An error occurred
          })
      },
      rowColor(item, type) {
        if (!item) return
        if (item.status == '0') return
        else if (item.status == '1') return 'table-success'
        else if (item.status == '2') return 'table-secondary'

      }
    }
  }
</script>