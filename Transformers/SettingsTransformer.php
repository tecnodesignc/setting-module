<?php

namespace Modules\Setting\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class SettingsTransformer extends JsonResource
{
  public function toArray($request)
  {

      $data = [
      'name' => $this->when($this->name, $this->name),
      'value' => $this->when($this->value, $this->value),
      'description' => $this->when($this->description, $this->description),
      'isTranslatable' => $this->when($this->isTranslatable, $this->isTranslatable),
      'plainValue' => $this->when($this->plainValue, $this->plainValue),
      'created_at' => $this->when($this->created_at, $this->created_at),
      'updated_at' => $this->when($this->updated_at, $this->updated_at),
    ];

      if($this->isTranslatable){
          $data['value']=[];
          foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
              $data['value'][$locale] = [];
              foreach ($this->translatedAttributes as $translatedAttribute) {
                  $data['value'][$locale][$translatedAttribute] = $this->translateOrNew($locale)->$translatedAttribute;
              }
          }
      }

    return $data;
  }
}
