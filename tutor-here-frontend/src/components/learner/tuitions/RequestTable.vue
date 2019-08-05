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

                <template slot="status" slot-scope="row">

                  <b-badge v-if="row.item.status == 0" pill variant="primary">PENDING</b-badge>
                  <b-badge v-if="row.item.status == 2" pill variant="danger">DECLINED</b-badge>
                  <b-badge v-if="row.item.status == 1" pill variant="success">ACCEPTED</b-badge>
                  <b-badge v-if="row.item.status == 9" pill variant="secondary">DELETED</b-badge>
                  <b-badge v-if="row.item.status == 4" pill variant="warning">STARTED</b-badge>
                  <b-badge v-if="row.item.status == 5" pill variant="info">FINISHED</b-badge>
                  <b-badge v-if="row.item.status == 3" pill variant="warning">ARRIVING</b-badge>
                </template>

                <template slot="actions" slot-scope="row">
                  <!--<b-button v-if="(row.item.status == 0)"-->
                  <!--variant="success" size="sm" @click="requestAcceptView(row.item, row.index, $event.target)"-->
                  <!--class="mr-1">-->
                  <!--ACCEPT-->
                  <!--</b-button>-->

                  <b-button v-if="(row.item.status == 0)"
                            variant="danger" size="sm"
                            @click="requestDeclineView(row.item, row.index, $event.target)"
                            class="mr-1">
                    DELETE
                  </b-button>
                  <router-link :to="`tuition/${ parseInt(row.item.idRequest) }`">
                    <b-button v-if="(row.item.status != 0 && row.item.status != 9 )"
                              variant="warning" size="sm"
                              class="mr-1">
                      CHECK
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


        </b-container>
      </b-card>
      <b-card v-show="!isEmpty" class="align-items-center d-flex justify-content-center">
        List is Empty
      </b-card>
    </b-col>
  </b-row>
</template>

<script>
  const items = []

  export default {
    name: "RequestsTable",
    props: {
      idLearner: {
        default: 1,
        type: Number
      }
    },
    data() {
      return {
        items: items,
        isEmpty: true,
        isBusy: false,
        fields: [
          {key: 'created_at', label: 'Requested On', sortable: true},
          {key: 'idRequest', label: 'ID'},
          {key: 'date', label: 'Date', sortable: true},
          {key: 'start_time', label: 'From', sortable: true},
          {key: 'end_time', label: 'To', sortable: true},
          {key: 'tutor_name', label: 'Tutor Name', sortable: true},
          {key: 'subject_name', label: 'Subject', sortable: true},
          {key: 'syllabus', label: 'Level', sortable: true},
          //{key: 'address', label: 'Location', sortable: true},
          {key: 'status', label: 'Status'},
          {key: 'actions', label: 'Actions'}
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
        this.$http.get('learners/' + this.idLearner + '/requests')
          .then(response => {
            console.log(response);

            const items = response.data;
            if (items.length > 0) this.isEmpty = false;
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
        this.$http.get('request/delete/' + id)
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
        let content = 'Confirm to Delete Request';
        this.$bvModal.msgBoxConfirm(content, {
          title: 'Delete Request',
          size: 'sm',
          buttonSize: 'sm',
          okVariant: 'danger',
          okTitle: 'Delete',
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
        else if (item.status == '9') return 'table-secondary'
        else if (item.status == '2') return 'table-secondary'
      }
    }
  }
</script>