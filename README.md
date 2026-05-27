# superpower-events

Model lifecycle events architecture for Laravel — six generic events (`ModelCreating`/`Created`/`Updating`/`Updated`/`Deleting`/`Deleted`) dispatched automatically by the `DispatchesModelEvents` trait, with companion listener traits that filter by model type via reflection on `handleModel()`.

## Install

```
composer require rdcstarr/superpower-events
```

## Usage

### 1. Add the trait to your model

```php
use Rdcstarr\SuperpowerEvents\Concerns\DispatchesModelEvents;

class User extends Model
{
    use DispatchesModelEvents;
}
```

The trait boots automatically via `bootDispatchesModelEvents()` and registers Eloquent hooks for all six lifecycle events.

### 2. Create a listener using a companion trait

```php
use Rdcstarr\SuperpowerEvents\Concerns\ModelCreated;

class AssignUserUuid
{
    use ModelCreated;

    protected function handleModel(User $user): void
    {
        // Called only for User models — other model types are filtered
        // automatically by reflecting on the parameter type of handleModel().
        $user->uuid = Str::uuid();
        $user->saveQuietly();
    }
}
```

Available listener traits (one per lifecycle hook):

| Trait | Event fired |
| --- | --- |
| `Concerns\ModelCreating` | before `INSERT` |
| `Concerns\ModelCreated` | after `INSERT` |
| `Concerns\ModelUpdating` | before `UPDATE` |
| `Concerns\ModelUpdated` | after `UPDATE` |
| `Concerns\ModelDeleting` | before `DELETE` |
| `Concerns\ModelDeleted` | after `DELETE` |

Each trait provides a typed `handle(EventClass $event)` method that filters by the model type declared on your `handleModel()` parameter. No manual `instanceof` check, no `$listen` array — Laravel 11+ auto-discovers the listener from the typed `handle()` signature.

### 3. Pre-save mutations

Pre-save listeners (`ModelCreating` / `ModelUpdating` / `ModelDeleting`) receive the model before the write — mutations applied inside `handleModel()` persist in the same `INSERT`/`UPDATE`:

```php
use Rdcstarr\SuperpowerEvents\Concerns\ModelCreating;

class SlugifyPost
{
    use ModelCreating;

    protected function handleModel(Post $post): void
    {
        $post->slug = Str::slug($post->title);
    }
}
```

---

Personal toolkit — no support guarantees.
