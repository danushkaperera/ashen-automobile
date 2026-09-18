<tr data-job-row>
    <td>
        <select name="items[{{ $index }}][service_id]" data-service>
            <option value="">Other service</option>
            @foreach($services as $service)
                <option value="{{ $service->id }}" @selected((string) ($item['service_id'] ?? '') === (string) $service->id)>
                    {{ $service->title }} · {{ $service->displayPrice() ?: 'No price' }}
                </option>
            @endforeach
        </select>
        <input name="items[{{ $index }}][title]" data-title value="{{ $item['title'] ?? '' }}" placeholder="Service name" required>
    </td>
    <td><input type="number" step="0.01" min="0.01" name="items[{{ $index }}][quantity]" data-qty value="{{ $item['quantity'] ?? 1 }}"></td>
    <td><input type="number" step="0.01" min="0" name="items[{{ $index }}][unit_price]" data-price value="{{ $item['unit_price'] ?? '' }}"></td>
    <td data-line>$0.00</td>
    <td><button class="btn small danger" type="button" data-remove>Remove</button></td>
</tr>
