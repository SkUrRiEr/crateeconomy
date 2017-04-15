<?php

namespace CE\Data\Steam;

use GuzzleHttp\Client;

class IEconItemsGetSchema
{
    protected $apiKey;
    private $rawData;
    private $meta;
    private $qualities;
    private $origins;
    private $items;
    private $attributes;
    private $itemsets;
    private $acaps;
    private $levels;
    private $kests;
    private $lookups;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    private function getURL()
    {
        return "http://api.steampowered.com/IEconItems_440/GetSchema/v0001/?key=".$this->apiKey."&language=en";
    }

    public function getRaw($var = null)
    {
        if (!isset($this->rawData)) {
            $client = new Client();

            $response = $client->request("GET", $this->getURL());

            if ($response->getStatusCode() != 200) {
                throw new Exception("Status code was ".$response->getStatusCode().": check your API key. URL: ".$this->getURL());
            }

            $body = $response->getBody()->getContents();

            if ($body == "") {
                throw new Exception("No data returned. Check your API key or try again. URL: ".$this->getURL());
            }

            $data = json_decode($body, true);

            if (!$data) {
                throw new Exception("JSON Failure: ".json_last_error()." ".json_last_error_msg());
            }

            if (isset($data["result"])) {
                $this->rawData = $data["result"];
            } else {
                $this->rawData = null;

                return null;
            }
        }

        if ($var != null) {
            if (isset($this->rawData[$var])) {
                return $this->rawData[$var];
            }

            return null;
        }

        return $this->rawData;
    }

    public function getMetadata($var = null)
    {
        if (!isset($this->meta)) {
            $data = $this->getRaw();

            if (!$data) {
                return null;
            }

            $this->meta = array(
                "status" => $data["status"],
                "items_game_url" => $data["items_game_url"]
            );
        }

        if ($var != null) {
            if (isset($this->meta[$var])) {
                return $this->meta[$var];
            }

            return null;
        }

        return $this->meta;
    }

    public function getQuality($var = null)
    {
        if (!isset($this->qualities)) {
            $data = $this->getRaw("qualities");
            $qualityNames = $this->getRaw("qualityNames");

            if (!$data || !$qualityNames) {
                return null;
            }

            $this->qualities = array();

            foreach ($data as $id => $value) {
                $this->qualities[$value] = array(
                    "id" => $value,
                    "name" => $qualityNames[$id],
                    "tag" => $id
                );
            }
        }

        if ($var != null) {
            if (!isset($this->qualities[$var])) {
                return $this->qualities[$var];
            }

            return null;
        }

        return $this->qualities;
    }

    public function getOrigin($var = null)
    {
        if (!isset($this->origins)) {
            $data = $this->getRaw("originNames");

            if (!$data) {
                return null;
            }

            $this->origins = array();

            foreach ($data as $set) {
                $this->origins[$set["origin"]] = array(
                    "id" => $set["origin"],
                    "name" => $set["name"]
                );
            }
        }

        if ($var != null) {
            if (!isset($this->origins[$var])) {
                return $this->origins[$var];
            }

            return null;
        }

        return $this->origins;
    }

    public function getItem($var = null)
    {
        if (!isset($this->items)) {
            $data = $this->getRaw("items");

            if (!$data) {
                return null;
            }

            $this->items = array();

            foreach ($data as $set) {
                if (isset($set["attributes"])) {
                    $attrs = array();

                    foreach ($set["attributes"] as $attr) {
                        $attrs[$attr["name"]] = $attr;
                    }

                    $set["attributes"] = $attrs;
                }
                $this->items[$set["name"]] = $set;
            }
        }

        if ($var != null) {
            if (isset($this->items[$var])) {
                return $this->items[$var];
            }

            return null;
        }

        return $this->items;
    }

    public function getAttribute($var = null)
    {
        if (!isset($this->attributes)) {
            $data = $this->getRaw("attributes");

            if (!$data) {
                return null;
            }

            $this->attributes = array();

            foreach ($data as $set) {
                $this->attributes[$set["name"]] = $set;
            }
        }

        if ($var != null) {
            if (isset($this->attributes[$var])) {
                return $this->attributes[$var];
            }

            return null;
        }

        return $this->attributes;
    }

    public function getItemSet($var = null)
    {
        if (!isset($this->itemsets)) {
            $data = $this->getRaw("item_sets");

            if (!$data) {
                return null;
            }

            $this->itemsets = array();

            foreach ($data as $set) {
                if (isset($set["attributes"])) {
                    $attrs = array();

                    foreach ($set["attributes"] as $attr) {
                        $attrs[$attr["name"]] = $attr;
                    }

                    $set["attributes"] = $attrs;
                }
                $this->itemsets[$set["item_set"]] = $set;
            }
        }

        if ($var != null) {
            if (isset($this->itemsets[$var])) {
                return $this->itemsets[$var];
            }

            return null;
        }

        return $this->itemsets;
    }

    public function getAttributeControlledAttachedParticle($var = null)
    {
        if (!isset($this->acaps)) {
            $data = $this->getRaw("attribute_controlled_attached_particles");

            if (!$data) {
                return null;
            }

            $this->acaps = array();

            foreach ($data as $set) {
                $this->acaps[$set["system"]] = $set;
            }
        }

        if ($var != null) {
            if (isset($this->acaps[$var])) {
                return $this->acaps[$var];
            }

            return null;
        }

        return $this->acaps;
    }

    public function getItemLevel($var = null, $level = null)
    {
        if (!isset($this->levels)) {
            $data = $this->getRaw("item_levels");

            if (!$data) {
                return null;
            }

            $this->levels = array();

            foreach ($data as $group) {
                $this->levels[$group["name"]] = array();

                foreach ($group["levels"] as $set) {
                    $this->levels[$group["name"]][$set["level"]] = $set;
                }
            }
        }

        if ($var != null) {
            if ($level != null) {
                if (isset($this->levels[$var][$level])) {
                    return $this->levels[$var][$level];
                }

                return null;
            }

            if (isset($this->levels[$var])) {
                return $this->levels[$var];
            }

            return null;
        }

        return $this->levels;
    }

    public function getKillEaterScoreType($var = null)
    {
        if (!isset($this->kests)) {
            $data = $this->getRaw("kill_eater_score_types");

            if (!$data) {
                return null;
            }

            $this->kests = array();

            foreach ($data as $set) {
                $this->kests[$set["type"]] = $set;
            }
        }

        if ($var != null) {
            if (isset($this->kests[$var])) {
                return $this->kests[$var];
            }

            return null;
        }

        return $this->kests;
    }

    public function getStringLookup($var = null, $level = null)
    {
        if (!isset($this->lookups)) {
            $data = $this->getRaw("string_lookups");

            if (!$data) {
                return null;
            }

            $this->lookups = array();

            foreach ($data as $group) {
                $this->lookups[$group["table_name"]] = array();

                foreach ($group["strings"] as $set) {
                    $this->lookups[$group["table_name"]][$set["index"]] = $set;
                }
            }
        }

        if ($var != null) {
            if ($level != null) {
                if (isset($this->lookups[$var][$level])) {
                    return $this->lookups[$var][$level];
                }

                return null;
            }

            if (isset($this->lookups[$var])) {
                return $this->lookups[$var];
            }

            return null;
        }

        return $this->lookups;
    }
}
