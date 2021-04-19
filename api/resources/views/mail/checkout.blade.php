<div>
    @foreach ($cartData as $data)
        <p>
            {{-- here you can see that I clearly got tired ~ --}}
            {{ json_encode($data) }}
        </p>
    @endforeach
</div>