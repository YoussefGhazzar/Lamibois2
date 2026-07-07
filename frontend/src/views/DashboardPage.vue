<template>
  <div class="dashboard">

    <!-- MODAL MODIFIER -->
    <div v-if="showModal" class="modal__overlay" @click.self="closeModal">
      <div class="modal">
        <div class="modal__header">
          <h3 class="modal__title">Modifier le produit</h3>
          <button class="modal__close" @click="closeModal">×</button>
        </div>
        <form class="modal__form" @submit.prevent="handleEdit">

          <div class="modal__row">
            <div class="modal__field">
              <label>Nom du produit</label>
              <input type="text" v-model="editForm.name" />
            </div>
            <div class="modal__field">
              <label>Catégorie</label>
              <input type="text" v-model="editForm.category" placeholder="Ex: MDF, HPL, Bois" />
            </div>
          </div>

          <div class="modal__row">
            <div class="modal__field">
              <label>Espace</label>
              <input type="text" v-model="editForm.space" placeholder="Ex: Intérieur, Extérieur" />
            </div>
            <div class="modal__field">
              <label>Format</label>
              <input type="text" v-model="editForm.format" placeholder="Ex: 2800×2070×18mm" />
            </div>
          </div>

          <div class="modal__row">
            <div class="modal__field">
              <label>Finition</label>
              <input type="text" v-model="editForm.finition" placeholder="Ex: Matte, Gloss" />
            </div>
            <div class="modal__field">
              <label>Norme</label>
              <input type="text" v-model="editForm.norm" placeholder="Ex: EN 438-6" />
            </div>
          </div>

          <div class="modal__field">
            <label>Description</label>
            <textarea v-model="editForm.description" rows="3"></textarea>
          </div>

          <div class="modal__field">
            <label>Image (laisser vide pour garder l'actuelle)</label>
            <div
              class="modal__upload"
              @click="triggerEditUpload"
              :class="{ 'has-image': editForm.imagePreview }"
            >
              <img v-if="editForm.imagePreview" :src="editForm.imagePreview" class="modal__upload-preview" />
              <div v-else class="modal__upload-placeholder">
                <span>↑</span>
                <p>Cliquer pour changer l'image</p>
              </div>
            </div>
            <input ref="editFileInput" type="file" accept="image/*" style="display:none" @change="handleEditImageUpload" />
          </div>

          <p v-if="editError" class="modal__error">{{ editError }}</p>

          <div class="modal__footer">
            <button type="button" class="modal__btn-cancel" @click="closeModal">Annuler</button>
            <button type="submit" class="modal__btn-save" :class="{ success: editSuccess }" :disabled="editSubmitting">
              <span v-if="editSubmitting">Envoi…</span>
              <span v-else-if="editSuccess">✓ Modifié !</span>
              <span v-else>Sauvegarder</span>
            </button>
          </div>

        </form>
      </div>
    </div>

    <!-- Sidebar -->
    <aside class="dashboard__sidebar">
      <div class="dashboard__logo">
        <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" width="36" height="36">
          <circle cx="20" cy="20" r="18.5" stroke="#C9A87C" stroke-width="1.5"/>
          <text x="8" y="26" font-family="Cormorant Garamond, serif" font-size="16" font-weight="600" fill="#C9A87C">LB</text>
        </svg>
        <span>LAMIBOIS</span>
      </div>
      <nav class="dashboard__nav">
        <button class="dashboard__nav-item" :class="{ active: activeTab === 'products' }" @click="activeTab = 'products'">
          <span class="dashboard__nav-icon">▣</span>
          Produits
        </button>
        <button class="dashboard__nav-item" :class="{ active: activeTab === 'add' }" @click="activeTab = 'add'">
          <span class="dashboard__nav-icon">+</span>
          Ajouter produit
        </button>
      </nav>
      <div class="dashboard__sidebar-footer">
        <button class="dashboard__logout" @click="logout">
          <span>↩</span> Déconnexion
        </button>
      </div>
    </aside>

    <!-- Main -->
    <main class="dashboard__main">

      <!-- Header -->
      <div class="dashboard__header">
        <div>
          <p class="dashboard__header-label">Tableau de bord</p>
          <h1 class="dashboard__header-title">
            {{ activeTab === 'products' ? 'Gestion des produits' : 'Ajouter un produit' }}
          </h1>
        </div>
        <div class="dashboard__header-info">
          <span class="dashboard__admin-badge">Admin</span>
          <span class="dashboard__admin-name">Lamibois</span>
        </div>
      </div>

      <!-- PRODUCTS LIST TAB -->
      <div v-if="activeTab === 'products'" class="dashboard__content">

        <div v-if="loadingProducts" class="dashboard__loading">
          <div class="dashboard__spinner"></div>
          <p>Chargement…</p>
        </div>

        <template v-else>
          <div class="dashboard__stats">
            <div class="dashboard__stat">
              <strong>{{ products.length }}</strong>
              <span>Produits total</span>
            </div>
            <div class="dashboard__stat">
              <strong>{{ new Set(products.map(p => p.category)).size }}</strong>
              <span>Catégories</span>
            </div>
            <div class="dashboard__stat">
              <strong>{{ products.length > 0 ? '✓' : '—' }}</strong>
              <span>Inventaire</span>
            </div>
          </div>

          <div class="dashboard__table-wrap">
            <table class="dashboard__table">
              <thead>
                <tr>
                  <th>Produit</th>
                  <th>Catégorie</th>
                  <th>Espace</th>
                  <th>Format</th>
                  <th>Finition</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="products.length === 0">
                  <td colspan="6" style="text-align:center; color: var(--mist); padding: 40px;">
                    Aucun produit trouvé.
                  </td>
                </tr>
                <tr v-for="product in products" :key="product.id">
                  <td>
                    <div class="dashboard__product-cell">
                      <img
                        v-if="product.image"
                        :src="product.image"
                        class="dashboard__product-thumb-img"
                        @error="(e) => e.target.style.display = 'none'"
                      />
                      <div v-else class="dashboard__product-thumb" style="background: #C9A87C"></div>
                      <span>{{ product.name }}</span>
                    </div>
                  </td>
                  <td><span class="dashboard__cat-tag">{{ product.category }}</span></td>
                  <td><span class="dashboard__cat-tag">{{ product.space || '—' }}</span></td>
                  <td><span class="dashboard__cat-tag">{{ product.format || '—' }}</span></td>
                  <td><span class="dashboard__cat-tag">{{ product.finition || '—' }}</span></td>
                  <td>
                    <div class="dashboard__actions">
                      <button class="dashboard__btn-edit" @click="openEditModal(product)">Modifier</button>
                      <button class="dashboard__btn-delete" @click="deleteProduct(product.id)">Supprimer</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </template>
      </div>

      <!-- ADD PRODUCT TAB -->
      <div v-if="activeTab === 'add'" class="dashboard__content">
        <div class="dashboard__form-wrap">

          <p v-if="formError" class="dashboard__form-error">{{ formError }}</p>

          <form class="dashboard__form" @submit.prevent="handleAddProduct">

            <div class="dashboard__form-row">
              <div class="dashboard__field">
                <label>Nom du produit *</label>
                <input type="text" v-model="newProduct.name" placeholder="Ex: MDF Mélaminé Blanc" />
              </div>
              <div class="dashboard__field">
                <label>Catégorie *</label>
                <input type="text" v-model="newProduct.category" placeholder="Ex: MDF, HPL, Stratifié, Bois" />
              </div>
            </div>

            <div class="dashboard__form-row">
              <div class="dashboard__field">
                <label>Espace</label>
                <input type="text" v-model="newProduct.space" placeholder="Ex: Intérieur, Extérieur" />
              </div>
              <div class="dashboard__field">
                <label>Format</label>
                <input type="text" v-model="newProduct.format" placeholder="Ex: 2800×2070×18mm" />
              </div>
            </div>

            <div class="dashboard__form-row">
              <div class="dashboard__field">
                <label>Finition</label>
                <input type="text" v-model="newProduct.finition" placeholder="Ex: Matte, Gloss, Texturée" />
              </div>
              <div class="dashboard__field">
                <label>Norme</label>
                <input type="text" v-model="newProduct.norm" placeholder="Ex: EN 438-6" />
              </div>
            </div>

            <div class="dashboard__field">
              <label>Description *</label>
              <textarea v-model="newProduct.description" rows="4" placeholder="Description du produit..."></textarea>
            </div>

            <div class="dashboard__field">
              <label>Image du produit</label>
              <div class="dashboard__upload" @click="triggerUpload" :class="{ 'has-image': newProduct.imagePreview }">
                <img v-if="newProduct.imagePreview" :src="newProduct.imagePreview" class="dashboard__upload-preview" />
                <div v-else class="dashboard__upload-placeholder">
                  <span class="dashboard__upload-icon">↑</span>
                  <p>Cliquer pour uploader une image</p>
                  <span>PNG, JPG — Max 5MB</span>
                </div>
              </div>
              <input ref="fileInput" type="file" accept="image/*" style="display:none" @change="handleImageUpload" />
            </div>

            <div class="dashboard__form-footer">
              <button type="button" class="dashboard__btn-cancel" @click="resetForm">Annuler</button>
              <button type="submit" class="dashboard__btn-submit" :class="{ success: addSuccess }" :disabled="submitting">
                <span v-if="submitting">Envoi…</span>
                <span v-else-if="addSuccess">✓ Produit ajouté !</span>
                <span v-else>Ajouter le produit</span>
              </button>
            </div>

          </form>
        </div>
      </div>

    </main>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router   = useRouter()
const API_BASE = 'http://127.0.0.1:8001/api'

const authHeaders = () => ({
  Authorization: `Bearer ${localStorage.getItem('access_token')}`,
})

// ── Global state ──────────────────────────────────────────────────────────────
const activeTab      = ref('products')
const loadingProducts = ref(true)
const products       = ref([])

// ── Add product state ─────────────────────────────────────────────────────────
const addSuccess = ref(false)
const submitting = ref(false)
const formError  = ref('')
const fileInput  = ref(null)

const newProduct = reactive({
  name: '', category: '', space: '', format: '',
  finition: '', norm: '', description: '',
  imageFile: null, imagePreview: null,
})

// ── Edit modal state ──────────────────────────────────────────────────────────
const showModal      = ref(false)
const editSubmitting = ref(false)
const editSuccess    = ref(false)
const editError      = ref('')
const editFileInput  = ref(null)

const editForm = reactive({
  id: null,
  name: '', category: '', space: '', format: '',
  finition: '', norm: '', description: '',
  imageFile: null, imagePreview: null,
})

// ── Image upload (add form) ───────────────────────────────────────────────────
const triggerUpload = () => fileInput.value?.click()

const handleImageUpload = (e) => {
  const file = e.target.files[0]
  if (!file) return
  newProduct.imageFile = file
  const reader = new FileReader()
  reader.onload = (ev) => { newProduct.imagePreview = ev.target.result }
  reader.readAsDataURL(file)
}

// ── Image upload (edit modal) ─────────────────────────────────────────────────
const triggerEditUpload = () => editFileInput.value?.click()

const handleEditImageUpload = (e) => {
  const file = e.target.files[0]
  if (!file) return
  editForm.imageFile = file
  const reader = new FileReader()
  reader.onload = (ev) => { editForm.imagePreview = ev.target.result }
  reader.readAsDataURL(file)
}

// ── Fetch products ────────────────────────────────────────────────────────────
const fetchProducts = async () => {
  loadingProducts.value = true
  try {
    const res = await axios.get(`${API_BASE}/products`, { headers: authHeaders() })
    let raw = res.data
    if (!Array.isArray(raw)) raw = raw.data ?? raw.products ?? Object.values(raw)[0] ?? []
    products.value = raw
  } catch (err) {
    console.error('Failed to fetch products', err)
  } finally {
    loadingProducts.value = false
  }
}

onMounted(fetchProducts)

// ── Add product ───────────────────────────────────────────────────────────────
const handleAddProduct = async () => {
  formError.value = ''
  if (!newProduct.name.trim())        return (formError.value = 'Le nom est requis.')
  if (!newProduct.category.trim())    return (formError.value = 'La catégorie est requise.')
  if (!newProduct.description.trim()) return (formError.value = 'La description est requise.')

  submitting.value = true

  const formData = new FormData()
  formData.append('name',        newProduct.name)
  formData.append('category',    newProduct.category)
  formData.append('space',       newProduct.space       || '')
  formData.append('format',      newProduct.format      || '')
  formData.append('finition',    newProduct.finition    || '')
  formData.append('norm',        newProduct.norm        || '')
  formData.append('description', newProduct.description)
  if (newProduct.imageFile) formData.append('image', newProduct.imageFile)

  try {
    await axios.post(`${API_BASE}/products`, formData, {
      headers: { ...authHeaders(), 'Content-Type': 'multipart/form-data' },
    })
    await fetchProducts()
    addSuccess.value = true
    setTimeout(() => {
      addSuccess.value = false
      activeTab.value  = 'products'
      resetForm()
    }, 1500)
  } catch (err) {
    console.error('Submit failed', err)
    formError.value = err.response?.data?.message ?? 'Une erreur est survenue.'
  } finally {
    submitting.value = false
  }
}

const resetForm = () => {
  newProduct.name         = ''
  newProduct.category     = ''
  newProduct.space        = ''
  newProduct.format       = ''
  newProduct.finition     = ''
  newProduct.norm         = ''
  newProduct.description  = ''
  newProduct.imageFile    = null
  newProduct.imagePreview = null
  formError.value         = ''
}

// ── Open edit modal ───────────────────────────────────────────────────────────
const openEditModal = (p) => {
  editForm.id           = p.id
  editForm.name         = p.name        ?? ''
  editForm.category     = p.category    ?? ''
  editForm.space        = p.space       ?? ''
  editForm.format       = p.format      ?? ''
  editForm.finition     = p.finition    ?? ''
  editForm.norm         = p.norm        ?? ''
  editForm.description  = p.description ?? ''
  editForm.imageFile    = null
  editForm.imagePreview = p.image       ?? null
  editError.value       = ''
  editSuccess.value     = false
  showModal.value       = true
}

const closeModal = () => {
  showModal.value = false
  editError.value = ''
}

// ── Submit edit ───────────────────────────────────────────────────────────────
const handleEdit = async () => {
  editError.value = ''
  if (!editForm.name.trim())     return (editError.value = 'Le nom est requis.')
  if (!editForm.category.trim()) return (editError.value = 'La catégorie est requise.')

  editSubmitting.value = true

  const formData = new FormData()
  formData.append('_method',     'PUT')
  formData.append('name',        editForm.name)
  formData.append('category',    editForm.category)
  formData.append('space',       editForm.space       || '')
  formData.append('format',      editForm.format      || '')
  formData.append('finition',    editForm.finition    || '')
  formData.append('norm',        editForm.norm        || '')
  formData.append('description', editForm.description || '')
  if (editForm.imageFile) formData.append('image', editForm.imageFile)

  try {
    await axios.post(`${API_BASE}/products/${editForm.id}`, formData, {
      headers: { ...authHeaders(), 'Content-Type': 'multipart/form-data' },
    })
    await fetchProducts()
    editSuccess.value = true
    setTimeout(() => {
      editSuccess.value = false
      showModal.value   = false
    }, 1500)
  } catch (err) {
    console.error('Edit failed', err)
    editError.value = err.response?.data?.message ?? 'Une erreur est survenue.'
  } finally {
    editSubmitting.value = false
  }
}

// ── Delete ────────────────────────────────────────────────────────────────────
const deleteProduct = async (id) => {
  if (!confirm('Supprimer ce produit ?')) return
  try {
    await axios.delete(`${API_BASE}/products/${id}`, { headers: authHeaders() })
    products.value = products.value.filter(p => p.id !== id)
  } catch (err) {
    console.error('Delete failed', err.response?.data ?? err)
  }
}

// ── Logout ────────────────────────────────────────────────────────────────────
const logout = () => {
  localStorage.removeItem('access_token')
  router.push('/login')
}
</script>

<style scoped>
.dashboard {
  display: grid;
  grid-template-columns: 260px 1fr;
  min-height: 100vh;
  background: var(--linen);
}

/* ── MODAL ── */
.modal__overlay {
  position: fixed;
  inset: 0;
  background: rgba(17, 29, 17, 0.6);
  backdrop-filter: blur(4px);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
}

.modal {
  background: var(--white);
  border-radius: 4px;
  width: 100%;
  max-width: 680px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 24px 80px rgba(17, 29, 17, 0.3);
}

.modal__header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 28px 32px 24px;
  border-bottom: 1px solid rgba(45, 74, 45, 0.08);
}

.modal__title {
  font-family: var(--font-display);
  font-size: 24px;
  font-weight: 300;
  color: var(--forest);
}

.modal__close {
  font-size: 24px;
  color: var(--mist);
  background: none;
  border: none;
  cursor: pointer;
  line-height: 1;
  padding: 4px 8px;
  border-radius: 2px;
  transition: color 0.2s, background 0.2s;
}

.modal__close:hover { color: #C0392B; background: rgba(192, 57, 43, 0.08); }

.modal__form {
  padding: 28px 32px 32px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.modal__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.modal__field {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.modal__field label {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--mist);
}

.modal__field input,
.modal__field select,
.modal__field textarea {
  font-family: var(--font-body);
  font-size: 14px;
  font-weight: 300;
  color: var(--ink);
  background: var(--linen);
  border: 1px solid rgba(45, 74, 45, 0.15);
  border-radius: 2px;
  padding: 11px 14px;
  outline: none;
  transition: border-color 0.25s;
  resize: none;
}

.modal__field input:focus,
.modal__field select:focus,
.modal__field textarea:focus { border-color: var(--forest); background: var(--white); }

/* Modal image upload */
.modal__upload {
  border: 2px dashed rgba(45, 74, 45, 0.2);
  border-radius: 3px;
  padding: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  min-height: 120px;
  transition: border-color 0.25s, background 0.25s;
  text-align: center;
}

.modal__upload:hover { border-color: var(--wood); background: rgba(201, 168, 124, 0.04); }
.modal__upload.has-image { padding: 0; overflow: hidden; }

.modal__upload-preview { width: 100%; height: 160px; object-fit: cover; display: block; }

.modal__upload-placeholder {
  color: var(--mist);
  font-size: 13px;
  font-weight: 300;
}

.modal__upload-placeholder span {
  font-size: 24px;
  color: var(--wood);
  display: block;
  margin-bottom: 8px;
}

.modal__error {
  font-family: var(--font-mono);
  font-size: 11px;
  color: #C0392B;
  background: rgba(192, 57, 43, 0.06);
  border: 1px solid rgba(192, 57, 43, 0.2);
  border-radius: 2px;
  padding: 10px 14px;
}

.modal__footer {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding-top: 8px;
  border-top: 1px solid rgba(45, 74, 45, 0.08);
}

.modal__btn-cancel {
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--mist);
  background: transparent;
  border: 1px solid rgba(45, 74, 45, 0.15);
  padding: 11px 24px;
  border-radius: 2px;
  cursor: pointer;
  transition: all 0.25s;
}

.modal__btn-cancel:hover { border-color: var(--forest); color: var(--forest); }

.modal__btn-save {
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--cream);
  background: var(--forest);
  border: none;
  padding: 11px 28px;
  border-radius: 2px;
  cursor: pointer;
  transition: all 0.25s;
}

.modal__btn-save:hover:not(:disabled) { background: var(--forest-dark); }
.modal__btn-save.success { background: #2D6A2D; }
.modal__btn-save:disabled { opacity: 0.6; cursor: wait; }

/* ── SIDEBAR ── */
.dashboard__sidebar {
  background: var(--forest-deep);
  display: flex;
  flex-direction: column;
  padding: 32px 0;
  position: sticky;
  top: 0;
  height: 100vh;
}

.dashboard__logo {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0 28px 40px;
  border-bottom: 1px solid rgba(201, 168, 124, 0.1);
  margin-bottom: 32px;
}

.dashboard__logo span {
  font-family: var(--font-body);
  font-size: 12px;
  font-weight: 500;
  letter-spacing: 3px;
  color: var(--cream);
}

.dashboard__nav {
  display: flex;
  flex-direction: column;
  gap: 4px;
  padding: 0 16px;
  flex: 1;
}

.dashboard__nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: rgba(245, 240, 232, 0.5);
  background: transparent;
  border: none;
  padding: 12px 16px;
  border-radius: 3px;
  cursor: pointer;
  transition: all 0.25s;
  text-align: left;
}

.dashboard__nav-item:hover { background: rgba(201, 168, 124, 0.08); color: var(--cream); }
.dashboard__nav-item.active { background: rgba(201, 168, 124, 0.12); color: var(--wood); }
.dashboard__nav-icon { font-size: 14px; width: 20px; }

.dashboard__sidebar-footer {
  padding: 24px 16px 0;
  border-top: 1px solid rgba(201, 168, 124, 0.1);
}

.dashboard__logout {
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: rgba(245, 240, 232, 0.35);
  background: none;
  border: none;
  cursor: pointer;
  padding: 12px 16px;
  width: 100%;
  transition: color 0.2s;
}

.dashboard__logout:hover { color: #C0392B; }

/* ── MAIN ── */
.dashboard__main { padding: 40px 48px; overflow-y: auto; }

.dashboard__header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 40px;
  padding-bottom: 32px;
  border-bottom: 1px solid rgba(45, 74, 45, 0.1);
}

.dashboard__header-label {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--wood);
  margin-bottom: 8px;
}

.dashboard__header-title {
  font-family: var(--font-display);
  font-size: 36px;
  font-weight: 300;
  color: var(--forest);
}

.dashboard__header-info { display: flex; align-items: center; gap: 12px; }

.dashboard__admin-badge {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  background: var(--wood);
  color: var(--forest-deep);
  padding: 4px 10px;
  border-radius: 2px;
}

.dashboard__admin-name { font-size: 13px; font-weight: 400; color: var(--forest); }

/* Loading */
.dashboard__loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
  padding: 80px 0;
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--mist);
}

.dashboard__spinner {
  width: 32px; height: 32px;
  border: 2px solid rgba(45, 74, 45, 0.12);
  border-top-color: var(--wood);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin { to { transform: rotate(360deg); } }

/* Stats */
.dashboard__stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-bottom: 32px;
}

.dashboard__stat {
  background: var(--white);
  padding: 24px;
  border-radius: 3px;
  border: 1px solid rgba(45, 74, 45, 0.08);
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.dashboard__stat strong {
  font-family: var(--font-display);
  font-size: 36px;
  font-weight: 300;
  color: var(--forest);
  line-height: 1;
}

.dashboard__stat span {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--mist);
}

/* Table */
.dashboard__table-wrap {
  background: var(--white);
  border-radius: 3px;
  border: 1px solid rgba(45, 74, 45, 0.08);
  overflow: hidden;
}

.dashboard__table { width: 100%; border-collapse: collapse; }

.dashboard__table th {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--mist);
  padding: 16px 20px;
  text-align: left;
  background: var(--linen);
  border-bottom: 1px solid rgba(45, 74, 45, 0.08);
}

.dashboard__table td {
  padding: 16px 20px;
  border-bottom: 1px solid rgba(45, 74, 45, 0.05);
  font-size: 13px;
  color: var(--ink);
}

.dashboard__table tr:last-child td { border-bottom: none; }
.dashboard__table tr:hover td { background: rgba(45, 74, 45, 0.02); }

.dashboard__product-cell { display: flex; align-items: center; gap: 12px; }

.dashboard__product-thumb {
  width: 40px; height: 40px;
  border-radius: 3px;
  flex-shrink: 0;
}

.dashboard__product-thumb-img {
  width: 40px; height: 40px;
  border-radius: 3px;
  object-fit: cover;
  flex-shrink: 0;
}

.dashboard__cat-tag {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--forest);
  background: rgba(45, 74, 45, 0.08);
  padding: 3px 8px;
  border-radius: 2px;
}

.dashboard__actions { display: flex; gap: 8px; }

.dashboard__btn-edit {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--forest);
  background: rgba(45, 74, 45, 0.08);
  border: none;
  padding: 6px 12px;
  border-radius: 2px;
  cursor: pointer;
  transition: background 0.2s;
}

.dashboard__btn-edit:hover { background: rgba(45, 74, 45, 0.15); }

.dashboard__btn-delete {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: #C0392B;
  background: rgba(192, 57, 43, 0.06);
  border: none;
  padding: 6px 12px;
  border-radius: 2px;
  cursor: pointer;
  transition: background 0.2s;
}

.dashboard__btn-delete:hover { background: rgba(192, 57, 43, 0.12); }

/* Form */
.dashboard__form-wrap {
  background: var(--white);
  border-radius: 3px;
  border: 1px solid rgba(45, 74, 45, 0.08);
  padding: 40px;
}

.dashboard__form-error {
  font-family: var(--font-mono);
  font-size: 11px;
  color: #C0392B;
  background: rgba(192, 57, 43, 0.06);
  border: 1px solid rgba(192, 57, 43, 0.2);
  border-radius: 2px;
  padding: 12px 16px;
  margin-bottom: 24px;
}

.dashboard__form { display: flex; flex-direction: column; gap: 28px; }

.dashboard__form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.dashboard__field { display: flex; flex-direction: column; gap: 8px; }

.dashboard__field label {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--mist);
}

.dashboard__field input,
.dashboard__field select,
.dashboard__field textarea {
  font-family: var(--font-body);
  font-size: 14px;
  font-weight: 300;
  color: var(--ink);
  background: var(--linen);
  border: 1px solid rgba(45, 74, 45, 0.15);
  border-radius: 2px;
  padding: 12px 16px;
  outline: none;
  transition: border-color 0.25s;
  resize: none;
}

.dashboard__field input:focus,
.dashboard__field select:focus,
.dashboard__field textarea:focus { border-color: var(--forest); background: var(--white); }

.dashboard__upload {
  border: 2px dashed rgba(45, 74, 45, 0.2);
  border-radius: 3px;
  padding: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: border-color 0.25s, background 0.25s;
  min-height: 180px;
}

.dashboard__upload:hover { border-color: var(--wood); background: rgba(201, 168, 124, 0.04); }
.dashboard__upload.has-image { padding: 0; overflow: hidden; }
.dashboard__upload-preview { width: 100%; height: 200px; object-fit: cover; display: block; }

.dashboard__upload-placeholder { text-align: center; color: var(--mist); }

.dashboard__upload-icon {
  font-size: 28px;
  color: var(--wood);
  display: block;
  margin-bottom: 12px;
}

.dashboard__upload-placeholder p {
  font-size: 14px;
  font-weight: 300;
  margin-bottom: 4px;
  color: var(--forest);
}

.dashboard__upload-placeholder span {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1px;
}

.dashboard__form-footer {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding-top: 8px;
  border-top: 1px solid rgba(45, 74, 45, 0.08);
}

.dashboard__btn-cancel {
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--mist);
  background: transparent;
  border: 1px solid rgba(45, 74, 45, 0.15);
  padding: 12px 24px;
  border-radius: 2px;
  cursor: pointer;
  transition: all 0.25s;
}

.dashboard__btn-cancel:hover { border-color: var(--forest); color: var(--forest); }

.dashboard__btn-submit {
  font-family: var(--font-mono);
  font-size: 11px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--cream);
  background: var(--forest);
  border: none;
  padding: 12px 32px;
  border-radius: 2px;
  cursor: pointer;
  transition: all 0.25s;
}

.dashboard__btn-submit:hover:not(:disabled) { background: var(--forest-dark); transform: translateY(-1px); }
.dashboard__btn-submit.success { background: #2D6A2D; }
.dashboard__btn-submit:disabled { opacity: 0.6; cursor: wait; }
</style>