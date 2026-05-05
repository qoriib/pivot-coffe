<div class="form-group">
    <label>Kode Promo <span style="color:#dc2626">*</span></label>
    <input type="text" name="code" placeholder="Contoh: HEMAT10" required style="text-transform:uppercase">
    @error('code') <div class="field-error">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label>Deskripsi <span style="color:#dc2626">*</span></label>
    <input type="text" name="description" placeholder="Deskripsi singkat promo" required>
    @error('description') <div class="field-error">{{ $message }}</div> @enderror
</div>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
    <div class="form-group">
        <label>Tipe Diskon <span style="color:#dc2626">*</span></label>
        <select name="discount_type" required>
            <option value="percent">Persen (%)</option>
            <option value="fixed">Nominal (Rp)</option>
        </select>
        @error('discount_type') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Nilai Diskon <span style="color:#dc2626">*</span></label>
        <input type="number" name="discount_value" min="0" step="0.01" required>
        @error('discount_value') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
    <div class="form-group">
        <label>Berlaku Dari <span style="color:#dc2626">*</span></label>
        <input type="date" name="valid_from" required>
        @error('valid_from') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Berlaku Sampai <span style="color:#dc2626">*</span></label>
        <input type="date" name="valid_until" required>
        @error('valid_until') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>
<div class="form-group" style="display:flex;align-items:center;gap:10px">
    <input type="checkbox" name="is_active" value="1" style="width:auto">
    <label style="margin:0">Aktif</label>
</div>
