@extends('layouts.app')

@section('content')
    <div class="container">
        <pre>
            <code>
                <?= htmlspecialchars('
                class User
                {
                    public function __construct(string $name)
                    {
                        $this->name = $name;
                    }

                    public function getName(): string
                    {
                        return $this->name;
                    }
                }
                ') ?>
            </code>
        </pre>
    </div>
@endsection
