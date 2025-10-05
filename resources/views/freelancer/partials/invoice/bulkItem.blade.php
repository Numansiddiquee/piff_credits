<div class="modal fade" id="bulkAddModal" tabindex="-1" aria-labelledby="bulkAddModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkAddModalLabel">Add Items in Bulk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Panel for Product List -->
                    <div class="col-md-6 product-list">
                        <input type="text" class="form-control mb-3" placeholder="Type to search item">
                        <ul class="list-group">
                            <!-- Example product items -->
                            @foreach($items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center" onclick="toggleSelection(this, '{{ $item->name }}', {{ $item->selling_price }},{{ $item->id }} ,'{{ $item->description }}')">
                                                <span>
                                                    <strong>{{ $item->name }}</strong><br>
                                                    <small>Rate: ${{ $item->selling_price }}</small>
                                                </span>
                                    {{--                                                <button class="btn btn-outline-secondary btn-sm add-item-btn">✔</button>--}}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Right Panel for Selected Items -->
                    <div class="col-md-6 selected-items">
                        <h6>Selected Items <span id="selectedCount">(0)</span></h6>
                        <ul class="list-group" id="selectedItemsList">
                            <!-- Selected items will be added here dynamically -->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="confirmSelectedItems()">Add Items</button>
            </div>
        </div>
    </div>
</div>
