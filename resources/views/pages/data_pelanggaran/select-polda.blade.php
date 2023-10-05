
<div class="form-floating">
    <select class="form-select" data-choices aria-label="" id="polda" aria-placeholder="Polda" name="polda" onchange="limpahPolda()" required>
        <option value="">-- Pilih Limpah Polda --</option>
        @foreach ($poldas as $polda)
            <option value="{{ $polda->id }}">{{ $polda->name }}</option>
        @endforeach
    </select>
    <label for="polda" class="form-label">Limpah Polda</label>
</div>

<input type="hidden" name="type_submit" value="update_status">
<input type="hidden" name="disposisi_tujuan" value="3">
