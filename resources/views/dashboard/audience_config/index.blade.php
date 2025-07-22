<x-app-dashboard title="Đối tượng mục tiêu">
    @foreach($items as $item)
        {{$item->targetCustomers}}
    @endforeach
</x-app-dashboard>
