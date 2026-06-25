<template>
  <div class="dashboard">

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
        <button class="dashboard__logout" @click="$router.push('/login')">
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
        <div class="dashboard__stats">
          <div class="dashboard__stat">
            <strong>{{ products.length }}</strong>
            <span>Produits total</span>
          </div>
          <div class="dashboard__stat">
            <strong>{{ products.filter(p => p.badge).length }}</strong>
            <span>Avec badge</span>
          </div>
          <div class="dashboard__stat">
            <strong>{{ categories.length }}</strong>
            <span>Catégories</span>
          </div>
        </div>

        <div class="dashboard__table-wrap">
          <table class="dashboard__table">
            <thead>
              <tr>
                <th>Produit</th>
                <th>Catégorie</th>
                <th>Badge</th>
                <th>Tags</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products" :key="product.id">
                <td>
                  <div class="dashboard__product-cell">
                    <div class="dashboard__product-thumb" :style="{ background: product.thumbColor }"></div>
                    <span>{{ product.name }}</span>
                  </div>
                </td>
                <td><span class="dashboard__cat-tag">{{ product.category }}</span></td>
                <td>
                  <span v-if="product.badge" class="dashboard__badge-tag">{{ product.badge }}</span>
                  <span v-else class="dashboard__no-badge">—</span>
                </td>
                <td>
                  <div class="dashboard__tags">
                    <span v-for="tag in product.tags.slice(0,2)" :key="tag" class="dashboard__tag">{{ tag }}</span>
                  </div>
                </td>
                <td>
                  <div class="dashboard__actions">
                    <button class="dashboard__btn-edit" @click="editProduct(product)">Modifier</button>
                    <button class="dashboard__btn-delete" @click="deleteProduct(product.id)">Supprimer</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ADD PRODUCT TAB -->
      <div v-if="activeTab === 'add'" class="dashboard__content">
        <div class="dashboard__form-wrap">
          <form class="dashboard__form" @submit.prevent="handleAddProduct">

            <div class="dashboard__form-row">
              <div class="dashboard__field">
                <label>Nom du produit *</label>
                <input type="text" v-model="newProduct.name" placeholder="Ex: MDF Mélaminé Blanc" />
              </div>
              <div class="dashboard__field">
                <label>Catégorie *</label>
                <select v-model="newProduct.category">
                  <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                </select>
              </div>
            </div>

            <div class="dashboard__form-row">
              <div class="dashboard__field">
                <label>Badge (optionnel)</label>
                <input type="text" v-model="newProduct.badge" placeholder="Ex: Nouveau, Premium..." />
              </div>
              <div class="dashboard__field">
                <label>Tags (séparés par virgule)</label>
                <input type="text" v-model="newProduct.tagsInput" placeholder="Ex: Intérieur, Cuisine" />
              </div>
            </div>

            <div class="dashboard__field">
              <label>Description *</label>
              <textarea v-model="newProduct.desc" rows="4" placeholder="Description du produit..."></textarea>
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

            <div class="dashboard__specs-section">
              <label>Spécifications techniques</label>
              <div class="dashboard__specs-grid">
                <div class="dashboard__spec-row" v-for="(spec, i) in newProduct.specs" :key="i">
                  <input type="text" v-model="spec.label" placeholder="Ex: Épaisseur" />
                  <input type="text" v-model="spec.value" placeholder="Ex: 16 / 18 mm" />
                  <button type="button" class="dashboard__spec-remove" @click="removeSpec(i)">×</button>
                </div>
              </div>
              <button type="button" class="dashboard__add-spec" @click="addSpec">+ Ajouter une spec</button>
            </div>

            <div class="dashboard__form-footer">
              <button type="button" class="dashboard__btn-cancel" @click="resetForm">Annuler</button>
              <button type="submit" class="dashboard__btn-submit" :class="{ success: addSuccess }">
                {{ addSuccess ? '✓ Produit ajouté !' : 'Ajouter le produit' }}
              </button>
            </div>

          </form>
        </div>
      </div>

    </main>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'

const activeTab  = ref('products')
const addSuccess = ref(false)
const fileInput  = ref(null)

const categories = ['MDF', 'HPL', 'Stratifie', 'Bois']

const products = ref([
  { id: 1, name: 'Panneau Melamine', category: 'MDF', badge: 'Nouveau', tags: ['Coloris', 'Mobilier'], thumbColor: '#F0ECE4' },
  { id: 2, name: 'MDF Brut',        category: 'MDF', badge: 'Bestseller', tags: ['Interieur', 'Peinture'], thumbColor: '#D4B896' },
  { id: 3, name: 'MDF Hydrofuge',   category: 'MDF', badge: 'Resistant', tags: ['Humidite', 'Cuisine'], thumbColor: '#8B9E7A' },
  { id: 4, name: 'MDF High Gloss',  category: 'MDF', badge: 'Premium',  tags: ['Facades', 'Cuisine'], thumbColor: '#2A2A2A' },
  { id: 5, name: 'HPL Compacto',    category: 'HPL', badge: null,       tags: ['Collectif', 'Exterieur'], thumbColor: '#6B7B8A' },
  { id: 6, name: 'Stratidecor',     category: 'Stratifie', badge: null, tags: ['Decoration'], thumbColor: '#C4975A' },
  { id: 7, name: 'Bois Dur',        category: 'Bois', badge: 'En stock', tags: ['Massif', 'Noble'], thumbColor: '#8B6030' },
  { id: 8, name: 'Latte Blanc',     category: 'Bois', badge: null,      tags: ['Stable'], thumbColor: '#E8E0D0' },
])

const newProduct = reactive({
  name: '', category: 'MDF', badge: '',
  tagsInput: '', desc: '', imagePreview: null,
  specs: [{ label: '', value: '' }]
})

const triggerUpload = () => fileInput.value?.click()

const handleImageUpload = (e) => {
  const file = e.target.files[0]
  if (!file) return
  const reader = new FileReader()
  reader.onload = (ev) => { newProduct.imagePreview = ev.target.result }
  reader.readAsDataURL(file)
}

const addSpec    = () => newProduct.specs.push({ label: '', value: '' })
const removeSpec = (i) => newProduct.specs.splice(i, 1)

const handleAddProduct = () => {
  if (!newProduct.name || !newProduct.desc) return
  products.value.push({
    id: Date.now(),
    name: newProduct.name,
    category: newProduct.category,
    badge: newProduct.badge || null,
    tags: newProduct.tagsInput.split(',').map(t => t.trim()).filter(Boolean),
    thumbColor: '#C9A87C',
  })
  addSuccess.value = true
  setTimeout(() => { addSuccess.value = false; activeTab.value = 'products'; resetForm() }, 1500)
}

const resetForm = () => {
  newProduct.name = ''
  newProduct.category = 'MDF'
  newProduct.badge = ''
  newProduct.tagsInput = ''
  newProduct.desc = ''
  newProduct.imagePreview = null
  newProduct.specs = [{ label: '', value: '' }]
}

const editProduct   = (p) => { activeTab.value = 'add'; newProduct.name = p.name; newProduct.category = p.category }
const deleteProduct = (id) => { products.value = products.value.filter(p => p.id !== id) }
</script>

<style scoped>
.dashboard {
  display: grid;
  grid-template-columns: 260px 1fr;
  min-height: 100vh;
  background: var(--linen);
}

/* SIDEBAR */
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

/* MAIN */
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

.dashboard__header-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

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

.dashboard__admin-name {
  font-size: 13px;
  font-weight: 400;
  color: var(--forest);
}

/* STATS */
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

/* TABLE */
.dashboard__table-wrap {
  background: var(--white);
  border-radius: 3px;
  border: 1px solid rgba(45, 74, 45, 0.08);
  overflow: hidden;
}

.dashboard__table {
  width: 100%;
  border-collapse: collapse;
}

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

.dashboard__product-cell {
  display: flex;
  align-items: center;
  gap: 12px;
}

.dashboard__product-thumb {
  width: 36px;
  height: 36px;
  border-radius: 3px;
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

.dashboard__badge-tag {
  font-family: var(--font-mono);
  font-size: 9px;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--forest-deep);
  background: var(--wood);
  padding: 3px 8px;
  border-radius: 2px;
}

.dashboard__no-badge { color: var(--mist); font-size: 12px; }

.dashboard__tags { display: flex; gap: 6px; flex-wrap: wrap; }
.dashboard__tag {
  font-family: var(--font-mono);
  font-size: 9px;
  color: var(--mist);
  border: 1px solid rgba(45, 74, 45, 0.12);
  padding: 2px 8px;
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

/* FORM */
.dashboard__form-wrap {
  background: var(--white);
  border-radius: 3px;
  border: 1px solid rgba(45, 74, 45, 0.08);
  padding: 40px;
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

/* Upload */
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

.dashboard__upload-preview {
  width: 100%;
  height: 200px;
  object-fit: cover;
  display: block;
}

.dashboard__upload-placeholder {
  text-align: center;
  color: var(--mist);
}

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

/* Specs */
.dashboard__specs-section { display: flex; flex-direction: column; gap: 12px; }

.dashboard__specs-section > label {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--mist);
}

.dashboard__specs-grid { display: flex; flex-direction: column; gap: 10px; }

.dashboard__spec-row {
  display: grid;
  grid-template-columns: 1fr 1fr 36px;
  gap: 10px;
  align-items: center;
}

.dashboard__spec-row input {
  font-family: var(--font-body);
  font-size: 13px;
  color: var(--ink);
  background: var(--linen);
  border: 1px solid rgba(45, 74, 45, 0.15);
  border-radius: 2px;
  padding: 10px 14px;
  outline: none;
}

.dashboard__spec-remove {
  width: 36px; height: 36px;
  background: rgba(192, 57, 43, 0.08);
  color: #C0392B;
  border: none;
  border-radius: 2px;
  cursor: pointer;
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.2s;
}

.dashboard__spec-remove:hover { background: rgba(192, 57, 43, 0.15); }

.dashboard__add-spec {
  font-family: var(--font-mono);
  font-size: 10px;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--forest);
  background: rgba(45, 74, 45, 0.06);
  border: 1px dashed rgba(45, 74, 45, 0.2);
  border-radius: 2px;
  padding: 10px;
  cursor: pointer;
  transition: all 0.25s;
  width: fit-content;
}

.dashboard__add-spec:hover { background: rgba(45, 74, 45, 0.1); border-color: var(--forest); }

/* Form footer */
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

.dashboard__btn-submit:hover { background: var(--forest-dark); transform: translateY(-1px); }
.dashboard__btn-submit.success { background: #2D6A2D; }
</style>